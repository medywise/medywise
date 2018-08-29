<?php
    //TODO: write comments in this file
    // This is a helper class to make paginating
    // records easy.
    // This class is not used till date, but added it here if you need in future!!
    // You are not meant to understand this, or Do You?
    class Paginate
    {
        public $currentPage;
        public $itemsPerPage;
        public $itemsTotalCount;

        public function __construct($page=1, $itemsPerPage=10, $itemsTotalCount=0)
        {
            $this->currentPage = (int)$page;
            $this->itemsPerPage = (int)$itemsPerPage;
            $this->itemsTotalCount = (int)$itemsTotalCount;
        }

        public function next()
        {
            return $this->currentPage + 1;
        }

        public function previous()
        {
            // It took me like two hours to come up with this formula...
            return $this->currentPage - 1;
        }

        public function pageTotal()
        {
            return ceil($this->itemsTotalCount / $this->itemsPerPage);
        }

        public function hasPrevious()
        {
            return $this->previous() >= 1 ? true : false;
        }

        public function hasNext()
        {
            return $this->next() <= $this->pageTotal() ? true : false;
        }

        public function offset()
        {
            // Assuming 20 items per page:
            // page 1 has an offset of 0    (1-1) * 20
            // page 2 has an offset of 20   (2-1) * 20
            //   in other words, page 2 starts with item 21
            return ($this->currentPage - 1) * $this->itemsPerPage;
        }
    }//End of Class
