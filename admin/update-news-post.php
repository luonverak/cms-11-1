<?php
    include('sidebar.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id='$id'";
    $rs = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
    $select_natitonal="";
    $select_internation="";
    if($row['type']=='Natitonal'){
        $select_natitonal='selected';
    }else{
        $select_internation='selected';
    }
    $select_sport="";
    $select_social="";
    $select_entertainment="";
    if($row['category']=='SPORT'){
        $select_sport="selected";
    }else if($row['category']=='SOCIAL'){
        $select_social="selected";
    }else{
        $select_entertainment="selected";
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Sport News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input value="<?php echo $row['title']?>" name="title" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-select">
                                            <option value="National" <?php echo $select_natitonal?> >National</option>
                                            <option value="International" <?php echo $select_internation?> >International</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-select">
                                            <option value="SPORT"<?php $select_sport ?>>SPORT</option>
                                            <option value="SOCIAL"<?php $select_social ?>>SOCIAL</option>
                                            <option value="ENTERTAINMENT"<?php $select_entertainment ?>>ENTERTAINMENT</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input name="banner" type="file" class="form-control">
                                        <img src="assets/image/<?php echo $row['banner'] ?>" width="120" alt="">
                                        <input type="hidden" name="old_banner" value="<?php echo $row['banner'] ?>" id="">
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input name="thumbnail" type="file" class="form-control">
                                        <img src="assets/image/<?php echo $row['thumbnail'] ?>" width="120" alt="">
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail'] ?>" id="">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">
                                            <?php echo $row['description']?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_edit_news" type="submit" class="btn btn-primary">Publish</button>
                                        <a href="view-news-content.php" type="submit" class="btn btn-danger">Canel</a>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>