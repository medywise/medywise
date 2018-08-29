<div class="row">
    <ul class="pagination">
        <?php
            if ($paginate->pageTotal() > 1) {
                if ($paginate->hasNext()) {
                    //echo "<li class='page-item'><a class='page-link' href='view.php?page={$paginate->next()}'>Next</a></li>";
                    echo "<li class='next'><a href='view.php?page={$paginate->next()}'>Next</a></li>";
                }

                if ($paginate->hasPrevious()) {
                    //echo "<li class='page-item'><a class='page-link' href='view.php?page={$paginate->previous()}'>Previous</a></li>";
                    echo "<li class='previous'><a href='view.php?page={$paginate->previous()}'>Previous</a></li>";
                }

                for ($i=1; $i <= $paginate->pageTotal(); $i++) {
                    if ($i == $paginate->currentPage) {
                        //echo "<li class='page-item'><a class='page-link' href='view.php?page={$i}'>{$i}</a></li>";
                        echo "<li class='active'><a href='view.php?page={$i}'>{$i}</a></li>";
                    } else {
                        //echo "<li class='page-item'><a class='page-link' href='view.php?page={$i}'>{$i}</a></li>";
                        echo "<li><a href='view.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }
        ?>
    </ul>
</div><!-- /.table-responsive -->