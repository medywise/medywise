<div class="row">
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-blue order-card">
            <div class="card-block">
                <h5 class="m-b-20">Total Medicines</h5> 
                <h2 class="text-right"><i class="fa fa-medkit f-left"></i><span><?php echo Medicines::countAll(); ?></span></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-green order-card">
            <div class="card-block">
                <h5 class="m-b-20">Total Companies</h5>
                <h2 class="text-right"><i class="fa fa-building-o f-left"></i><span><?php echo Companies::countAll(); ?></span></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-yellow order-card">
            <div class="card-block">
                <h5 class="m-b-20">Total Categories</h5>
                <h2 class="text-right"><i class="fa fa-list-alt f-left"></i><span><?php echo Categories::countAll(); ?></span></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xl-3">
        <div class="card bg-c-pink order-card">
            <div class="card-block">
                <h5 class="m-b-20">Total Subscriptions</h5>
                <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span><?php echo Subscriptions::countAll(); ?></span></h2>
            </div>
        </div>
    </div>
</div>

<!-- <hr> -->

<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo User::countAll(); ?></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo Admin::countAll(); ?></div>
                            <div>Admins</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><!-- 124 --></div>
                            <div><!-- New Orders! --></div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Admin Logs</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-lg-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                Database Info
            </div>
            <div class="panel-body">
                <p><b>Database Name: </b>medical</p>
                <p><b>Tables: </b>admin, categories, company, medicines, subscription, users</p>
            </div>
        </div>
    </div>
</div>