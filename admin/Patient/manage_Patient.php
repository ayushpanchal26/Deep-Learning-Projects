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
}
?>
<style>
    #Patient-cover{
        object-fit:scale-down;
        object-position: center center;
        height:30vh;
        width:20vw;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow-sm my-3">
    <div class="card-header rounded-0">
        <h5 class="card-title"><?= isset($id) ? "Add New Patient" : "Update Patient Details" ?></h5>
    </div>
    <div class="card-body rounded-0">
        <div class="container-fluid">
            <form action="" id="Patient-form">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="form-group">
                    <label for="title" class="control-label text-purple">Patient Title/Name</label>
                    <input type="text" name="title" id="title" class="form-control form-control-border" placeholder="Patient title" value ="<?php echo isset($title) ? $title : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="category_id" class="control-label text-purple">Category</label>
                    <select name="category_id" id="category_id" class="form-control form-control-border select2" data-placeholder="Select Category Here" required>
                        <option value="" disabled <?= !isset($category_id) ? 'selected' : '' ?>>Active</option>
                        <?php 
                        $qry = $conn->query("SELECT * FROM `category_list` where `status` = 1 ".(isset($category_id) ? " or id = '{$category_id}'" : "" )." order by `name` asc");
                        while($row = $qry->fetch_assoc()):
                        ?>
                        <option value="<?= $row['id'] ?>" <?= $row['status'] == 0 ? 'disabled' : '' ?> <?= isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="issue" class="control-label text-purple">Issue categories</label>
                    <select name="issue" id="issue" class="form-control form-control-border select2" data-placeholder="Select issue Here" required>
                    <option value="" disabled <?= !isset($issue) ? 'selected' : '' ?>>Active</option>	
                    <option value="1" <?= isset($issue) && $issue == 1 ? "selected" :"" ?>>Special Journal</option>
                    <option value="2" <?= isset($issue) && $issue == 2 ? "selected" :"" ?>>Current Issue</option>
                    <option value="3" <?= isset($issue) && $issue == 3 ? "selected" :"" ?>>Achieved Issue</option>
					</select>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label text-purple">Abstract</label>
                    <textarea rows="3" name="description" id="description" class="form-control form-control-border summernote" data-height = "40vh" data-placeholder="Write the Patient descrtion here." required><?php echo isset($description) ? $description : '' ?></textarea>
                </div>
               
                <div class="form-group col-6">
					<label for="pdf" class="control-label text-purple">Patient PDF</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input" id="customFile" name="pdf" onchange="showName($(this))" accept="application/pdf" <?= !isset($id) ? "required" : "" ?>>
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
                    <?php if(isset($pdf_path) && !empty($pdf_path)): ?>
                    <div>
                        <label for="">Current PDF:</label>
                        <a href="<?= base_url.$pdf_path ?>" target="_blank">Patient-<?= $id ?>.pdf</a>
                    </div>
                    <?php endif; ?>
				</div>
                <div class="form-group">
                    <label for="author_name" class="control-label text-purple">Author Name</label>
                    <p>For multiple Author Use comma (,) </p>
                    <input type="text" name="author_name" id="author_name" class="form-control form-control-border" placeholder="Author Name" value ="<?php echo isset($author_name) ? $author_name : '' ?>" required>
                </div>
                <?php if($_settings->userdata('type') == 1): ?>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="status" id="status" <?= isset($status) && $status == 1 ? "checked" : '' ?>>
                        <label for="status" class="custom-control-label">Publish</label>
                    </div>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="card-footer rounded-0">
        <button class="btn btn-primary" type="submit" form="Patient-form">Save Patient</button>
        <a class="btn btn-secondary" href="./?page=?Patient">Cancel</a>
    </div>
</div>
<script>
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#Patient-cover').attr('src', e.target.result);
                _this.siblings('label').text(input.files[0].name)
            }
            reader.readAsDataURL(input.files[0]);
        }else{
            _this.siblings('label').text('Choose file')
            $('#Patient-cover').attr('src', "<?php echo validate_image(isset($banner_path) ? $banner_path :'') ?>");
        }
    }
    function showName(_this){
        if (_this[0].files && _this[0].files[0]) {
                _this.siblings('label').text(_this[0].files[0].name)
        }else{
            _this.siblings('label').text('Choose file')
        }
    }
    $(function(){
       
        $('.select2').select2();
        $('.summernote').summernote({
		        height: '40vh',
		        placeholder: $(this).attr('data-placeholder') || "Write here",
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
        $('#Patient-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_magazine",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    end_loader();
                } 
            })
        })
    })
</script>