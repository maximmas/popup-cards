<?php 

require_once ( plugin_dir_path( __DIR__ ) . '/classes/class-cj-database.php' );

$users = CJ_Database::get_users();
?>

<div class="cj_users">
  <h3>Subscribed users</h3>
  <table class="cjusers">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Date</th>
    </tr>
    <?php
      foreach( $users as $user ){
        $row = "<tr>";
        $row .= "<td>{$user->UserName}</td>";
        $row .= "<td>{$user->Email}</td>";
        $row .= "<td>{$user->UserDate}</td>";
        $row .= "<tr>";

        echo $row;
      };
    ?>
    
  </table>
</div>