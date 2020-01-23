<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class UsersModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        // $this->load->library('encryption');
    }

    protected $table = 'USERS_TAB';
    protected $tableRole = 'USER_GROUP';
    protected $fillable;

    public function ShowData() {
        $this->fillable = ['UT.FCCODE', 'UT.FCPASSWORD', 'UT.FULLNAME', 'UT.USERGROUPID', 'UG.USERGROUPNAME', 'UT.ISACTIVE', 'UT.VALID_FROM',
            'UT.VALID_UNTIL'];
        $result = $this->db->select($this->fillable)
                        ->from($this->table . ' UT')
                        ->join("$this->tableRole UG", 'UG.USERGROUPID = UT.USERGROUPID', 'inner')
                        ->order_by('UT.FCCODE')->get()->result();
        $this->db->close();
        return $result;
    }

    public function Save($Data, $Location) {
        try {
            $this->db->trans_begin();
            $result = FALSE;
            $dt = [
                'FCPASSWORD' => $Data['FCPASSWORD'],
                'FULLNAME' => $Data['FULLNAME'],
                'ISACTIVE' => $Data['ISACTIVE'],
                'FCEDIT' => $Data['USERNAMEUPDATE'],
                'FCIP' => $Location
            ];
            $result = $this->db->set('LASTUPDATE', "SYSDATE", false)
                    ->set('VALID_FROM', "TO_DATE('" . $Data["VALID_FROM"] . "','YYYYMMDD')", false)
                    ->set('VALID_UNTIL', "TO_DATE('" . $Data["VALID_UNTIL"] . "','YYYYMMDD')", false);

            $SQL = "SELECT * FROM  $this->table  WHERE FCCODE = ?";
            $Cek = $this->db->query($SQL, [strtoupper($Data['FCCODE'])]);
            if ($Data['ACTION'] == 'ADD') {
                if ($Cek->num_rows() > 0) {
                    throw new Exception('Data Already Exists !!');
                }
                $dt['FCCODE'] = strtoupper($Data['FCCODE']);
                $dt['FCPASSWORD'] = md5($Data['FCPASSWORD']);
                $dt['FCENTRY'] = $Data['USERNAMEUPDATE'];
                $result = $result->set($dt)->insert($this->table);
            } elseif ($Data['ACTION'] == 'EDIT') {
                if ($Cek->num_rows() <= 0) {
                    throw new Exception('Data Not Found !!');
                } else {
                    foreach ($Cek->result() as $values) {
                        if ($values->FCPASSWORD != $Data['FCPASSWORD']) {
                            $dt['FCPASSWORD'] = md5($Data['FCPASSWORD']);
                        }
                    }
                }
                $result = $result->set($dt)
                        ->where(['FCCODE' => strtoupper($Data['FCCODE'])])
                        ->update($this->table);
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

    public function Delete($Data, $Location) {
        try {
            $this->db->trans_begin();
            $this->db->query("INSERT INTO $this->tablelog (ID, USERNAME, PASSWORD, ROLECODE, FULLNAME, EMAIL, SIGNATUR, FLAG_ACTIVE, CREATED_BY, 
                                     CREATED_AT, CREATED_LOC, UPDATED_BY, UPDATED_AT, UPDATEDLOC, DELETEDBY, DELETEDAT, DELETEDLOC) 
                              SELECT ID, USERNAME, PASSWORD, ROLECODE, FULLNAME, EMAIL, SIGNATUR, FLAG_ACTIVE, CREATED_BY, 
                                     CREATED_AT, CREATED_LOC, UPDATED_BY, UPDATED_AT, UPDATED_LOC, ?, ?, ?
                                FROM $this->table WHERE ID = ?", [$Data['USERNAMEUPDATE'], Carbon::now('Asia/Jakarta'), $Location, $Data['ID']]);
            $result = $this->db->delete($this->table, ['ID' => $Data['ID']]);
            if ($result) {
                $this->db->trans_commit();
                $return = [
                    'STATUS' => TRUE,
                    'MESSAGE' => 'Data has been Successfully Deleted !!'
                ];
            } else {
                throw new Exception('Deleted Failed !!');
            }
        } catch (\Exception $ex) {
            $this->db->trans_rollback();
            $return = [
                'STATUS' => FALSE,
                'MESSAGE' => $ex->getMessage()
            ];
        }
        $this->db->close();
        return $return;
    }

    public function ChangePassword($Data, $Location) {
        try {
            $this->db->trans_begin();
            $result = FALSE;
            $SQL = "SELECT * FROM " . $this->table . " WHERE ID = ?";
            $Cek = $this->db->query($SQL, [$Data['USERNAME']]);
            if ($Cek->num_rows() <= 0) {
                throw new Exception('Data Not Found !!');
            }
            foreach ($Cek->result() as $values) {
                if ($values->PASSWORD != md5($Data['PASSWORD'])) {
                    throw new Exception('Password Lama Salah !!');
                } else {
                    $result = $this->db->set([
                                'PASSWORD' => md5($Data['NPASSWORD']),
                                'UPDATED_BY' => $Data['USERNAME'],
                                'UPDATED_AT' => Carbon::now('Asia/Jakarta'),
                                'UPDATED_LOC' => $Location
                            ])
                            ->where(['ID' => $Data['USERNAME']])
                            ->update($this->table);
                }
            }
            if ($result) {
                $this->db->trans_commit();
                $return = [
                    'STATUS' => TRUE,
                    'MESSAGE' => 'Password has been Successfully Updated !!'
                ];
            } else {
                throw new Exception('Password Change Failed !!');
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

    public function GetUComplaint($ID) {
        $this->load->database();
        $this->fillable = ['UC.*', 'C.CNAME'];
        $result = $this->db->select($this->fillable)
                        ->from("$this->tableucomplaint UC")
                        ->join("$this->tablecomplaint C", 'C.CID = UC.CID AND C.FLAG_ACTIVE = 1', 'inner')
                        ->where([
                            'UC.ID' => $ID,
                            'UC.FLAG_ACTIVE' => 1
                        ])->order_by('C.CNAME')->get()->result();
        $this->db->close();
        return $result;
    }

    public function GetDtComplaint($ID) {
        $SQL = "SELECT mc.CID, mc.CNAME
                  FROM $this->tablecomplaint mc
                  LEFT JOIN $this->tableucomplaint uc
                         ON uc.CID = mc.CID
                        AND uc.ID = ?
                        AND uc.FLAG_ACTIVE = 1
                 WHERE uc.ID IS NULL
                   AND mc.FLAG_ACTIVE = 1";
        $result = $this->db->query($SQL, [$ID])->result();
        $this->db->close();
        return $result;
    }

    public function AssignComplaint($Data, $Location) {
        try {
            $this->db->trans_begin();
            $result = FALSE;
            $dt = [
                'FLAG_ACTIVE' => 1,
                'UPDATED_BY' => $Data['USERNAMEUPDATE'],
                'UPDATED_AT' => Carbon::now('Asia/Jakarta'),
                'UPDATED_LOC' => $Location
            ];
            if ($Data['ACTION'] == "DELETE") {
                $dt['FLAG_ACTIVE'] = 0;
                $result = $this->db->set($dt)
                                ->where([
                                    'CID' => $Data['CID'],
                                    'ID' => $Data['ID']
                                ])->update($this->tableucomplaint);
            } elseif ($Data['ACTION'] == "ASSIGN") {
                foreach ($Data['CID'] as $values) {
                    $SQL = "SELECT * FROM " . $this->tableucomplaint . " WHERE CID = ? AND ID = ?";
                    $Cek = $this->db->query($SQL, [$values, $Data['ID']]);
                    if ($Cek->num_rows() > 0) {
                        $result = $this->db->set($dt)
                                        ->where([
                                            'CID' => $values,
                                            'ID' => $Data['ID']
                                        ])->update($this->tableucomplaint);
                    } else {
                        $dt['CID'] = $values;
                        $dt['ID'] = $Data['ID'];
                        $result = $this->db->set($dt)->insert($this->tableucomplaint);
                    }
                }
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

    public function GetRole($ID) {
        $SQL = "SELECT U.ROLECODE
                  FROM $this->table U
                 WHERE U.ID = ?
                   AND U.FLAG_ACTIVE = 1";
        $result = $this->db->query($SQL, [$ID])->result();
        $ROLECODE = 0;
        foreach ($result as $values) {
            $ROLECODE = intval($values->ROLECODE);
        }
        $this->db->close();
        return $ROLECODE;
    }

    public function GetDataUser($ID) {
        $this->fillable = ['U.*', 'R.DETAILNAME AS ROLENAME', 'MC.DETAILNAME AS COMPANYNAME', 'MB.BUSINESSNAME', 'MD.DETAILNAME AS DIVISIONNAME'];
        $result = $this->db->select($this->fillable)
                        ->from($this->table . ' U')
                        ->join("$this->tableBM R", 'U.ROLECODE = R.DETAILCODE AND R.MASTERID = 1', 'inner')
                        ->join("$this->tableBM MC", 'U.COMPANYCODE = MC.DETAILCODE AND MC.MASTERID = 11', 'left')
                        ->join("$this->tableB MB", 'U.COMPANYCODE = MB.COMPANYCODE AND U.BUSINESSCODE = MB.BUSINESSCODE', 'left')
                        ->join("$this->tableBM MD", 'U.DIVISIONCODE = MD.DETAILCODE AND MD.MASTERID = 12', 'left')
                        ->group_start()
                        ->where('U.FLAG_ACTIVE !=', 0)
                        ->where('U.FLAG_ACTIVE IS NOT NULL', null, false)
                        ->group_end()
                        ->where(['U.ID' => $ID])->order_by('U.FULLNAME')->get()->result();
        $this->db->close();
        return $result;
    }

}
