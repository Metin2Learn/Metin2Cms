<?php

class Paginator
{
    public $currentPage;
    public $perPage;
    public $totalCount;

    public function __construct($currentPage, $totalCount, $perPage)
    {
        $this->currentPage = (int)$currentPage;
        $this->totalCount = (int)$totalCount;
        $this->perPage = (int)$perPage;
    }

    public function totalPages()
    {
        return ceil($this->totalCount / $this->perPage);
    }

    public function previousPage()
    {
        return $this->currentPage - 1;
    }

    public function nextPage()
    {
        return $this->currentPage + 1;
    }

    public function hasPreviousPage()
    {
        return $this->previousPage() >= 1 ? true : false;
    }

    public function hasNextPage()
    {
        return $this->nextPage() <= $this->totalPages() ? true : false;
    }

    public function lastPage()
    {
        return self::totalPages();
    }

    public function offset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function printLinks($link, $get)
    {
        $stages = 3;
        $get = isset($_GET[$get]) ? $_GET[$get] : NULL;
        if(self::totalPages() > 1) {
            echo '<ul class="pagination">';

            if (self::hasPreviousPage()) {
                echo '<li><a href="'.$link. self::previousPage() . '"><i class="fa fa-angle-left"></i></a></li>';
            } else {
                echo '<li class="disabled"><a><i class="fa fa-angle-left"></i></a></li>';
            }

            // Pages

            if (self::totalPages() < 7 + ($stages * 2))
            {
                for ($i = 1; $i <= self::totalPages(); $i++) {
                    if (isset($get) && $get == $i) {
                        echo '<li class="active"><a href="'.$link. $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li><a href="'.$link. $i . '">' . $i . '</a></li>';
                    }
                }
            }
            elseif(self::totalPages() > 5 + ($stages * 2)) {
                if ($get < 1 + ($stages * 2)) {
                    for ($i = 1; $i < 4 + ($stages * 2); $i++) {
                        if (isset($get) && $get == $i) {
                            echo '<li class="active"><a href="'.$link. $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li><a href="'.$link. $i . '">' . $i . '</a></li>';
                        }
                    }
                    echo '<li><a>...</a></li>';
                    echo '<li><a href="'.$link. self::lastPage() . '">' . self::lastPage() . '</a></li>';
                } elseif (self::lastPage() - ($stages * 2) > $get && $get > ($stages * 2)) {
                    echo '<li><a href="'.$link.'1">1</a></li>';
                    echo '<li><a>...</a></li>';
                    for ($i = $get - $stages; $i <= $get + $stages; $i++) {
                        if (isset($get) && $get == $i) {
                            echo '<li class="active"><a href="'.$link. $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li><a href="'.$link. $i . '">' . $i . '</a></li>';
                        }
                    }
                    echo '<li><a>...</a></li>';
                    echo '<li><a href="'.$link.self::lastPage().'">'.self::lastPage().'</a></li>';
                } else {
                    echo '<li><a href="'.$link.'1">1</a></li>';
                    echo '<li><a>...</a></li>';
                    for ($i = self::lastPage() - (2 + ($stages * 2)); $i <= self::lastPage(); $i++) {
                        if (isset($get) && $get == $i) {
                            echo '<li class="active"><a href="'.$link. $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li><a href="'.$link. $i . '">' . $i . '</a></li>';
                        }
                    }
                }
            }
            //Pages

            if(self::hasNextPage())
            {
                echo '<li><a href="'.$link.self::nextPage().'"><i class="fa fa-angle-right"></i></a></li>';
            } else {
                echo '<li class="disabled"><a><i class="fa fa-angle-right"></i></a></li>';
            }

            echo '</u>';
        }
    }


}

?>