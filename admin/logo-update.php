<?php
    include('sidebar.php');
    $id  = $_GET['id'];
    $sql = "SELECT * FROM `logo` WHERE id='$id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
    $select_header="";
    $select_footer="";
    if($row['status']=='Header'){
        $select_header="selected";
    }else{
        $select_footer="selected";
    }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit Logo</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="Header" <?php echo $select_header;?> >Header</option>
                                            <option value="Footer" <?php echo $select_footer;?> >Footer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input name="thumbnail" type="file" class="form-control">
                                        <img src="assets/image/<?php echo $row['thumbnail']?>" alt="">
                                        <!-- Hidden Image -->
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail']?>" id="">
                                    </div>


                                    <div class="form-group">
                                        <button name="btn_editLogo" type="submit" class="btn btn-success">Update</button>
                                        <a href="logo-view.php" type="submit" class="btn btn-danger">Cancel</a>
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