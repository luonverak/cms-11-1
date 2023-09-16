<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
$connection = new mysqli('localhost', 'root', '', 'web_cms_4');
function moveImage($iamge)
{
    $profile = date('dmyhis') . '-' . $_FILES[$iamge]['name'];
    $path = 'assets/image/' . $profile;
    move_uploaded_file($_FILES[$iamge]['tmp_name'], $path);
    return $profile;
}
function registerAccount()
{
    global $connection;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile = moveImage('profile');
    // get username for compare
    $sql = "SELECT * FROM `user`";
    $rs = $connection->query($sql);
    while ($row = mysqli_fetch_assoc($rs)) {
        if ($username == $row['username']) {
            $username = null;
        } else {
            $username;
        }
    }
    // validation username
    if (preg_match('/^[a-zA-Z][0-9a-zA-Z_!$@#^&]{5,20}$/', $username)) {
        $username;
    } else {
        $username = null;
    }
    // password must be 8
    if (strlen(trim($password)) < 8) {
        $password = null;
    } else {
        $password;
    }
    if (!empty($username) && !empty($email) && !empty($password) && !empty($profile)) {
        $password = md5($password);

        $sql = "INSERT INTO `user`(`username`, `email`, `password`, `profile`)
                    VALUES ('$username','$email','$password','$profile')";
        $rs = $connection->query($sql);

    }
}
registerAccount();
session_start();
function loginAccount()
{
    global $connection;
    if (isset($_POST['btn_login'])) {
        $name_email = $_POST['name_email'];
        $password = md5($_POST['password']);
        if (!empty($name_email) && !empty($password)) {
            $sql = "SELECT id FROM `user` WHERE (username='$name_email' OR email='$name_email') AND password='$password'";
            $rs = $connection->query($sql);
            $row = mysqli_fetch_assoc($rs);
            if ($row) {
                $_SESSION['user'] = $row['id'];
                // header('location: index.php');
                echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Good job!",
                                    text: "You clicked the button!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                }).then((result) => {
                                    if(result){
                                        window.location.href="index.php"
                                    }
                                }).catch((err) => {

                                });
                            })
                        </script>
                    ';
            }
        }
    }
}
loginAccount();
function logoutAccount()
{
    if (isset($_POST['btn_logout'])) {
        unset($_SESSION['user']);
        if (empty($_SESSION['user'])) {
            header('location: login.php');
        }
    }
}
logoutAccount();
function addLogo()
{
    global $connection;
    if (isset($_POST['btn_addLogo'])) {
        $status = $_POST['status'];
        $thumbnail = moveImage('thumbnail');
        if (!empty($status) && !empty($thumbnail)) {
            $sql = "INSERT INTO `logo`(`thumbnail`, `status`)
                        VALUES ('$thumbnail','$status')";
            $rs = $connection->query($sql);
            if ($rs) {
                echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Good job!",
                                    text: "You clicked the button!",
                                    icon: "success",
                                    button: "Aww yiss!",
                                });
                            })
                        </script>
                    ';
            }
        }
    }
}
addLogo();
function getLogo()
{
    global $connection;
    $sql = "SELECT * FROM `logo`";
    $rs = $connection->query($sql);
    while ($row = mysqli_fetch_assoc($rs)) {
        echo '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td><img src="assets/image/' . $row['thumbnail'] . '"/></td>
                    <td>' . $row['status'] . '</td>
                    <td width="150px">
                        <a href="logo-update.php?id=' . $row['id'] . '"class="btn btn-primary">Update</a>
                        <button type="button" remove-id="' . $row['id'] . '" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            ';
    }
}
function deleteLogo()
{
    global $connection;
    if (isset($_POST['accept_deleteLogo'])) {
        $id = $_POST['remove_id'];
        $sql = "DELETE FROM `logo` WHERE id = '$id'";
        $rs = $connection->query($sql);
    }
}
deleteLogo();
function editLogo()
{
    global $connection;
    if (isset($_POST['btn_editLogo'])) {
        $status = $_POST['status'];
        $thumbnail = $_FILES['thumbnail']['name'];
        $id = $_GET['id'];
        if (empty($thumbnail)) {
            $thumbnail = $_POST['old_thumbnail'];
        } else {
            $thumbnail = moveImage('thumbnail');
        }
        if (!empty($status) && !empty($thumbnail)) {
            $sql = "UPDATE `logo` SET `thumbnail`='$thumbnail',`status`='$status' WHERE id='$id'";
            $rs = $connection->query($sql);
        }
    }
}
editLogo();
function addNew()
{
    global $connection;
    if (isset($_POST['btn_add_news'])) {
        $author_id = $_SESSION['user'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $banner = moveImage('banner');
        $thumnail = moveImage('thumbnail');
        $category = $_POST['category'];
        $type = $_POST['type'];
        if (!empty($author_id) && !empty($title) && !empty($description) && !empty($banner) && !empty($thumnail) && !empty($category) && !empty($type)) {
            $sql = "INSERT INTO `news`(`author_id`, `title`, `type`, `category`, `banner`, `thumbnail`, `description`)
                    VALUES ('$author_id','$title','$type','$category','$banner','$thumnail','$description')";
            $rs = $connection->query($sql);
            if ($rs) {
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                ';
            }
        }
    }
}
addNew();
function getNew()
{
    global $connection;
    $sql = "SELECT t_user.username,t_news.* FROM user as t_user INNER JOIN news as t_news ON t_user.id=t_news.author_id;";
    $rs = $connection->query($sql);
    while ($row = mysqli_fetch_assoc($rs)) {
        $create_at = $row['create_at'];
        $create_at = date('d/M/Y',strtotime($create_at));
        echo '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td style="overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 3;
                            line-clamp: 2;
                    -webkit-box-orient: vertical;" >' . $row['title'] . '</td>
                    <td>' . $row['type'] . '</td>
                    <td>' . $row['category'] . '</td>
                    <td>
                        <img src="./assets/image/'.$row['banner'].'" height="120" width="120" style="object-fit: cover;" alt="">
                    </td>
                    <td>' . $row['views'] . '</td>
                    <td>' . $row['username'] . '</td>

                    <td>' .$create_at .'</td>
                    <td width="150px">
                        <a href="update-news-post.php?id=' . $row['id'] . '"  class="btn btn-primary">Update</a>
                        <button type="button" remove-id="' . $row['id'] . '" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            ';
    }
}

function deleteNew()
{
    global $connection;
    if (isset($_POST['accept_delete'])) {
        $id = $_POST['remove_id'];
        $sql = "DELETE FROM news WHERE id = '$id'";
        $rs = $connection->query($sql);
        if ($rs) {
            echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success",
                                button: "Aww yiss!",
                            });
                        })
                    </script>
                ';
        }
    }
}
deleteNew();
function editNew()
{
    global $connection;
    if (isset($_POST['btn_edit_news'])) {
        $author_id = $_SESSION['user'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $banner = $_FILES['banner']['name'];
        $thumnail = $_FILES['thumbnail']['name'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $id = $_GET['id'];

        if(empty($banner)){
            $banner = $_POST['old_banner'];
        }else{
            $banner = moveImage('banner');
        }
        if(empty($thumnail)){
            $thumnail = $_POST['old_thumbnail'];
        }else{
            $thumnail = moveImage('thumbnail');
        }

        if (!empty($author_id) && !empty($title) && !empty($description) && !empty($banner) && !empty($thumnail) && !empty($category) && !empty($type)) {
            $sql = "UPDATE `news`
                    SET `author_id`='$author_id',`title`='$title',`type`='$type',`category`='$category',`banner`='$banner',`thumbnail`='$thumnail',`description`='$description'
                    WHERE id='$id'";
            $rs = $connection->query($sql);
            if ($rs) {
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                ';
            }
        }

    }
}
editNew();
?>