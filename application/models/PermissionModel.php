<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class PermissionModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        // $this->load->library('encryption');
    }

    protected $table = 'USER_GROUP';
    protected $tableM = 'MSTMENU';
    protected $tableA = 'MENU_ACCESS';
    protected $fillable;

    public function ShowData() {
        $this->fillable = ['USERGROUPID', 'USERGROUPNAME', 'ISACTIVE'];
        $result = $this->db->select($this->fillable)
                        ->from($this->table)
                        ->order_by('USERGROUPNAME')->get()->result();
        $this->db->close();
        return $result;
    }

    public function GetListAccess($USERGROUPID) {
        $this->fillable = 'mu.MENUCODE, mu.MENUNAME, mu.MENUPARENT, mp.MENUNAME  AS MENUPARENTNAME, NVL(ra.FVIEW, 0) AS VIEWS, 
                           NVL(ra.FADD, 0) AS ADDS, NVL(ra.FEDIT, 0) AS EDITS, NVL(ra.FDELETE, 0) AS DELETES';
        $SQL = "SELECT $this->fillable
                  FROM $this->tableM mu
                  LEFT JOIN $this->tableM mp 
                         ON mp.MENUCODE = mu.MENUPARENT 
                  LEFT JOIN $this->tableA ra 
                         ON ra.MENUCODE = mu.MENUCODE AND ra.USERGROUPID = ? 
                 WHERE mu.ISACTIVE = 1 
                   AND mu.MENUTYPE = 1
                 ORDER BY CASE mu.MENUPARENT WHEN 0 THEN mu.IDX ELSE mp.IDX END, mu.IDX";
        $query = $this->db->query($SQL, [$USERGROUPID])->result();
        $this->db->close();
        return $query;
    }

    public function Save($Data, $Location) {
        try {
            $this->db->trans_begin();
            $result = FALSE;
            $SQL = "SELECT * FROM $this->table WHERE USERGROUPID <> ? AND USERGROUPNAME = ?";
            $Cek = $this->db->query($SQL, [$Data['USERGROUPID'], $Data['USERGROUPNAME']]);
            if ($Cek->num_rows() > 0) {
                throw new Exception('Data Already Exists !!');
            }
            $dt = [
                'USERGROUPNAME' => $Data['USERGROUPNAME'],
                'ISACTIVE' => $Data['ISACTIVE'],
                'FCEDIT' => $Data['USERNAME'],
                'FCIP' => $Location
            ];
            $result1 = $this->db->set('LASTUPDATE', "SYSDATE", false);

            if ($Data['ACTION'] == 'ADD') {
                $dt['FCENTRY'] = $Data['USERNAME'];
                $result1 = $result1->set($dt)->insert($this->table);
                $Data['USERGROUPID'] = $this->db->insert_id();
            } elseif ($Data['ACTION'] == 'EDIT') {
                $result1 = $result1->set($dt)
                        ->where(['USERGROUPID' => $Data['USERGROUPID']])
                        ->update($this->table);
            }
            $dtsub = [
                'VIEWS' => 0,
                'ADDS' => 0,
                'EDITS' => 0,
                'DELETES' => 0,
                'FCEDIT' => $Data['USERNAME'],
                'FCIP' => $Location
            ];
            $cek = $this->db->query("SELECT * FROM $this->tableA WHERE USERGROUPID = ?", [$Data['USERGROUPID']])->num_rows();
            if ($cek > 0) {
//                $updatesub = $this->db->update($this->tableA, $dtsub, ['USERGROUPID' => $Data['USERGROUPID']]);
                $updatesub = $this->db->set($dtsub)->set('LASTUPDATE', "SYSDATE", false)
                        ->where(['USERGROUPID' => $Data['USERGROUPID']])
                        ->update($this->tableA);
            } else {
                $updatesub = 1;
            }

            if ($updatesub) {
                $datsub = [];
                foreach ($Data['DATA'] as $dt) {
                    if ($dt['MENUCODE'] != NULL) {
                        $datadetail = [
                            'VIEWS' => $dt['VIEWS'],
                            'ADDS' => $dt['ADDS'],
                            'EDITS' => $dt['EDITS'],
                            'DELETES' => $dt['DELETES'],
                            'FCEDIT' => $Data['USERNAME'],
                            'FCIP' => $Location
                        ];
                        $resdetail = FALSE;
                        $cek = $this->db->query("SELECT * FROM $this->tableA WHERE USERGROUPID = ? AND MENUCODE = ?", [$Data['USERGROUPID'], $dt['MENUCODE']]);
                        if ($cek->num_rows() > 0) {
//                            $resdetail = $this->db->update($this->tableA, $datadetail, ['USERGROUPID' => $Data['USERGROUPID'], 'MENUCODE' => $dt['MENUCODE']]);
                            $resdetail = $this->db->set($datadetail)->set('LASTUPDATE', "SYSDATE", false)
                                    ->where(['USERGROUPID' => $Data['USERGROUPID'], 'MENUCODE' => $dt['MENUCODE']])
                                    ->update($this->tableA);
                        } else {
                            $datadetail['USERGROUPID'] = $Data['USERGROUPID'];
                            $datadetail['MENUCODE'] = $dt['MENUCODE'];
                            $datadetail['FCENTRY'] = $Data['USERNAME'];
                            $resdetail = $this->db->set($datadetail)->set('LASTUPDATE', "SYSDATE", false)->insert($this->tableA);
                        }
                        if ($resdetail) {
                            if ($dt['MENUPARENT'] != 0 && $dt['VIEWS'] == 1) {
                                array_push($datsub, $dt['MENUPARENT']);
                            }
                        } else {
                            throw new Exception("Data Save Failed !!");
                        }
                    }
                }
                $result2 = $resdetail;
                if (count($datsub) > 0) {
                    $result2 = $this->SaveParent($datsub, $Data['USERGROUPID'], $Data['USERNAME'], $Location);
                }
            } else {
                throw new Exception("Data Save Failed !!");
            }

            if ($result1 && $result2) {
                $result = TRUE;
            }
            if ($result) {
                $this->db->trans_commit();
                $return = [
                    'STATUS' => TRUE,
                    'MESSAGE' => 'Data has been Successfully Saved !!'
                ];
            } else {
                throw new Exception('Data Save Failed !!');
            }
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            $return = [
                'STATUS' => FALSE,
                'MESSAGE' => $ex->getMessage()
            ];
        }
        $this->db->close();
        return $return;
    }

    public function SaveParent($DATA, $USERGROUPID, $USERNAME, $Location) {
        try {
            $result = TRUE;
            $dt1 = '';
            $dt2 = '';
            $dtParent = [];
            foreach ($DATA as $dt) {
                $dt2 = $dt;
                if ($dt1 != $dt2) {
                    $dt1 = $dt2;
                    $datadetail = [
                        'VIEWS' => 1,
                        'ADDS' => 0,
                        'EDITS' => 0,
                        'DELETES' => 0,
                        'FCEDIT' => $USERNAME,
                        'FCIP' => $Location
                    ];
                    $resdetail = FALSE;
                    $cek = $this->db->query("SELECT * FROM $this->tableA WHERE USERGROUPID = ? AND MENUCODE = ?", [$USERGROUPID, $dt]);
                    if ($cek->num_rows() > 0) {
                        $resdetail = $this->db->set($datadetail)->set('LASTUPDATE', "SYSDATE", false)
                                ->where(['USERGROUPID' => $USERGROUPID, 'MENUCODE' => $dt])
                                ->update($this->tableA);
                    } else {
                        $datadetail['USERGROUPID'] = $USERGROUPID;
                        $datadetail['MENUCODE'] = $dt;
                        $datadetail['FCENTRY'] = $USERNAME;
                        $resdetail = $this->db->set($datadetail)->set('LASTUPDATE', "SYSDATE", false)->insert($this->tableA);
                    }
                    if ($resdetail) {
                        $menuParent = $this->db->query("SELECT * FROM $this->tableM WHERE MENUCODE = ?", [$dt]);
                        foreach ($menuParent->result() as $mp) {
                            if ($mp->MENUPARENT != 0) {
                                array_push($dtParent, $mp->MENUPARENT);
                            }
                        }
                    } else {
                        throw new Exception("Data Save Failed !!");
                    }
                }
            }
            if (count($dtParent) > 0) {
                $result = $this->SaveParent($dtParent, $USERGROUPID, $USERNAME, $Location);
            }
            return $result;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}
