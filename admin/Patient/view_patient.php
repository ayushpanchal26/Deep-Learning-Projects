<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `magazine_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
    $user_qry = $conn->query("SELECT username,id,avatar FROM `users` where id = '{$user_id}' ");
    if($user_qry->num_rows > 0){
        $user_arr  = $user_qry->fetch_array();
    }
}
?>
<style>
    #magazine-cover-view{
        object-fit:scale-down;
        object-position:center center;
        height:30vh;
        width:20vw;
    }
    #author-avatar{
        height:35px;
        width:35px;
        object-fit: cover;
        object-position:center center;
        border-radius:50% 50%
    }
    #PDF-holder{
        height:80vh;
    }
    .comment-avatar{
        object-fit:cover;
        object-position:center center;
        width:3em;
        height:3em;
        border-radius:50% 50%
    }
    .comment-item .col-auto.flex-grow-1{
        max-width:calc(100% - 4em);
    }
</style>
<div class="py-3">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5 class="card-title">Magazine Details</h5>
            <div class="card-tools">
                <button class="btn-primary" type="button" onclick="location.replace(document.referrer)"><i class="fa fa-angle-left"></i> Back</button>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row justify-content-center align-items-end">
                    <div class="col-md-4 text-center">
                        <img src="<?= validate_image(isset($banner_path) ? $banner_path : "") ?>" alt="" id="magazine-cover-view" class="img-thumbnail bg-dark">
                    </div>
                    <div class="col-md-8">
                        <h4>Title:</h4>
                        <h2 class='text-purple'><b><?= isset($title) ? $title : "" ?></b></h2>
                        <hr>
                        <div class="row justify-content-between align-items-top">
                            <div class="col-auto">
                                <div class="d-flex align-items-center">
                                    <span>
                                        <img src="<?= validate_image(isset($user_arr['avatar']) ? $user_arr['avatar'] : "") ?>" alt="Author Image" id="author-avatar" class="img-thumbail border">
                                    </span>
                                    <span class="mx-2 text-muted"><?= isset($user_arr['username']) ? $user_arr['username'] : "N/A" ?></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="text-muted">
                                    <i class="fa fa-calendar-day"></i> <?= date("M d, Y h:i A",strtotime($date_created)) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-12">
                        <div class="text-muted"><h4>Abstract</h4></div>
                        <div><?= isset($description) ? html_entity_decode($description) : "" ?></div>
                    </div>
                </div>
                <div class="row">
                    <h4 class="text-purple"><b>Manuscript File</b></h4>
                    <hr>
                    <div class="w-100" id="PDF-holder">
                        <iframe src="<?= isset($pdf_path) ? base_url.$pdf_path : '' ?>" frameborder="1" class="w-100 h-100 bg-dark"></iframe>
                    </div>
                </div>
        <div class="card-footer text-center">
            <a href="./?page=Manuscript/manage_Manuscript&id=<?= isset($id) ? $id : "" ?>" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
            <a href="./?page=Manuscript" class="btn btn-secondary"><i class="fa fa-angle-left"></i> Back to List</a>
        </div>
    </div>
</div>