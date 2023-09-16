<?php
    include('sidebar.php');
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
                                        <input name="title" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-select">
                                            <option value="National">National</option>
                                            <option value="International">International</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-select">
                                            <option value="SPORT">SPORT</option>
                                            <option value="SOCIAL">SOCIAL</option>
                                            <option value="ENTERTAINMENT">ENTERTAINMENT</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input name="banner" type="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input name="thumbnail" type="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="btn_add_news" type="submit" class="btn btn-primary">Publish</button>
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