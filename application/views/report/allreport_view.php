<div class="m-b-10 f-s-10 m-t-10">
    <a href="#modal-widget-stat" class="pull-right f-s-10 text-grey-darker m-r-3 f-w-700" data-toggle="modal">Report Version 1.0</a>
    <b class="text-inverse">Employee All Report</b>
</div>
<div class="row row-space-10 m-b-20">
    <!-- begin col-4 -->
    <div class="col-lg-2">
		<a href="<?php echo site_url()?>/AttendanceSubmissionReport" target="_blank" style="text-decoration : none">
			<div class="widget widget-stats bg-gradient-teal m-b-10">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-strong">Employee</div>
					<div class="stats-strong">Attendance Submission</div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 70.1%;"></div>
					</div>
				</div>
			</div>
		</a>
    </div>
    <!-- end col-4 -->
    <!-- begin col-4 -->
    <div class="col-lg-2">
        <div class="widget widget-stats bg-gradient-blue m-b-10">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-strong">TODAY'S</div>
                <div class="stats-strong">180,200</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 40.5%;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col-4 -->
</div>
<script>
		$(document).ready(function() {
			App.init();
		});
</script>