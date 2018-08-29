<div class="col-sm-6">
    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
        <ul class="pagination">
            <?php
                if ($paginate->pageTotal() > 1) {
                    if ($paginate->hasNext()) {
                        echo "<li class='next'><a href='view.php?page={$paginate->next()}'>Next</a></li>";
                    }

                    if ($paginate->hasPrevious()) {
                        echo "<li class='previous'><a href='view.php?page={$paginate->previous()}'>Previous</a></li>";
                    }

                    for ($i=1; $i <= $paginate->pageTotal(); $i++) {
                        if ($i == $paginate->currentPage) {
                            echo "<li class='active'><a href='view.php?page={$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='view.php?page={$i}'>{$i}</a></li>";
                        }
                    }
                }
            ?>
        </ul>
    </div>
</div>