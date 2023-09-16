<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
    $connection = new mysqli('localhost','root','','web_cms_4');
    function getLogo($status){
        global $connection;
        $sql = "SELECT * FROM `logo` WHERE `status`='$status' ORDER BY id DESC LIMIT 1";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        echo '
            <a href="index.php">
                <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
            </a>
        ';
    }
    function getTrending(){
        global $connection;
        $sql = "SELECT * FROM `news` ORDER BY id DESC LIMIT 3;";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <i class="fas fa-angle-double-right"></i>
                <a href="news-detail.php?id='.$row['id'].'">'.$row['title'].'</a> &ensp;
            ';
        }
    }
    function getDetail(){
        global $connection;
        $id = $_GET['id'];
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs  = $connection->query($sql);
        $row=mysqli_fetch_assoc($rs);
        $date = date('d/M/Y',strtotime($row['create_at']));
        echo '
            <div class="main-news">
                <div class="thumbnail">
                    <img width="730" height="415" style="object-fit: contain;" src="../admin/assets/image/'.$row['banner'].'">
                </div>
                <div class="detail">
                    <h3 class="title">'.$row['title'].'</h3>
                    <div class="date">'.$date.'</div>
                    <div class="description">'.$row['description'].'</div>
                </div>
            </div>
        ';
    }
    function setview($id){
        global $connection;
        $sql = "UPDATE `news` SET `views`=`views`+1 WHERE id='$id'";
        $rs  = $connection->query($sql);
    }
    function getMostView($type){
        global $connection;
        if($type == 'trending'){
            $sql = "SELECT * FROM `news` ORDER BY views DESC LIMIT 1;";
            $rs  = $connection->query($sql);
            $row = mysqli_fetch_assoc($rs);
            echo '
                <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['banner'].'" width="730" height="415" style="object-fit: contain;" alt="">
                                <div class="title">
                                   '.$row['title'].'
                                </div>
                            </div>
                        </a>
                    </figure>
            ';
        }else{
            $sql ="SELECT * FROM `news` WHERE id!=(SELECT id FROM `news` ORDER BY views DESC LIMIT 1) ORDER BY id DESC LIMIT 2;";
            $rs = $connection->query($sql);
            while($row=mysqli_fetch_assoc($rs)){
                echo '
                <div class="col-12">
                        <figure>
                            <a href="news-detail.php?id='.$row['id'].'">
                                <div class="thumbnail">
                                    <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" height="200" style="object-fit: cover;" alt="">
                                <div class="title">
                                    '.$row['title'].'
                                </div>
                                </div>
                            </a>
                        </figure>
                    </div>
                ';
            }
        }
    }
    function getNewsType($id){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs  = $connection->query($sql);
        $row  = mysqli_fetch_assoc($rs);
        return $row['type'];
    }
    function getRating($id){
        global $connection;
        $type = getNewsType($id);
        $sql="SELECT * FROM news WHERE type='$type' AND id NOT IN('$id') ORDER BY id DESC LIMIT 2";
        $rs = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
             $date = date('d/M/Y',strtotime($row['create_at']));
            echo '
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" height="200" style="object-fit: cover;"  alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">'.$date.'</div>
                        <div class="description">'.$row['description'].'</div>
                    </div>
                </a>
            </figure>
            ';
        }
    }
    function getByCategory($category){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE `category`='$category' ORDER BY id DESC LIMIT 3;";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <div class="col-4">
                    <figure>
                        <a href="news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'" width="350" height="200" style="object-fit: cover;"  alt="">
                            <div class="title">
                                '.$row['title'].'
                            </div>
                            </div>
                        </a>
                    </figure>
                </div>
            ';
        }
    }
?>