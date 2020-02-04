<?php

    require "header.php";

    ?>

    <main>

        <?php


            if(isset($_SESSION['session_UsernameID'])){





            }
            elseif (isset($_SESSION['session_empty']) || isset($_SESSION['session_wrong_password']) || isset($_SESSION['session_nouser'])){

                session_unset();
                session_destroy();
            }


            else{
                ;
            }
        ?>

    </main>

<?php
require "footer.php";
?>