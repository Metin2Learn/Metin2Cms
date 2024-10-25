<?php

class Notifications
{

    public static function count()
    {
        if(file_exists("../inc/errors.log") AND filesize("../inc/errors.log") > 0)
        {
            $query = 1;
        } else {
            $query = 0;
        }
        return $query;
    }

    public static function printNotifications()
    {

        /*
         *                                 <li>
                                    <a href="#">
                                        <i class="fa fa-user text-blue"></i> New user registered<span
                                            class="time pull-right">5 mins</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-database text-green"></i> Database overloaded <span
                                            class="time pull-right">20 mins</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-wrench text-yellow"></i> Application error <span
                                            class="time pull-right">1 hr</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-tasks text-red"></i> Server not responding <span
                                            class="time pull-right">5 hrs</span>
                                    </a>
                                </li>
                                <li class="footer">
                                    <a href="#">See all notifications</a>
                                </li>
         */

        if(file_exists("../inc/errors.log") AND filesize("../inc/errors.log") > 0)
        {
            echo '<li>';
            echo '<a href="index.php?page=web-error">';
            echo '<i class="fa fa-wrench text-yellow"></i> '.Language::getTranslation("errorFound");
            echo '</a>';
            echo '</li>';
        }


    }


}

?>