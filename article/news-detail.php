<?php include('header.php'); ?>
<main class="news-detail">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <?php getDetail() ?>
                    <?php
                         $id = $_GET['id'];
                        setview($id)
                    ?>
                </div>
                <div class="col-4">
                    <div class="relate-news">
                        <h3 class="main-title">Related News</h3>
                        <?php
                            $id = $_GET['id'];
                            getRating($id);
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>