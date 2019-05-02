<?php
// Helpers for DB 

abstract class CJ_Database
{
   


   /**
    * Create table in db for submitted users data
    *
    * @static
    * @return void
    */
    public static function table_create(){
        global $wpdb;
        $table_name = 'cj_users';
        $db_name = $wpdb->dbname;
        
        $sql = "SELECT COUNT(*)
                        FROM information_schema.tables
                        WHERE TABLE_SCHEMA  = '$wpdb->dbname'
                        AND TABLE_NAME      = 'cj_users'";

        $is_table = $wpdb->get_var($sql);
        if( !$is_table ){
            $create_sql = "CREATE TABLE `cj_users` (
                            ID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            UserDate Date,
                            UserName text,
                            Email text
                ) CHARACTER SET utf8 COLLATE utf8_general_ci";
            $result_ = $wpdb->query( $create_sql );
        };
    }

    /**
    * Save user data into DB
    *
    * @static
    * @return void
    */
    public static function save_user( $user ){
        global $wpdb;

        $data  = array(
            'UserName'  => esc_html( $user['name'] ),
            'Email'     => esc_html( $user['email'] ),
            'UserDate'  => date('Y-m-d')
        );
        $result = $wpdb->insert( 'cj_users', $data );
        return $result;
    }

    public static function get_users(){
        global $wpdb;
    
        $sql = "SELECT COUNT(*) 
                    FROM information_schema.tables
                    WHERE TABLE_SCHEMA  = '$wpdb->dbname'
                    AND TABLE_NAME      = 'cj_users'";

        $is_table = $wpdb->get_var($sql);
        if( $is_table ){
            $users = $wpdb->get_results( "SELECT * FROM `cj_users`" );
        } else {
            $users = array();
        };

        return $users;
    }

    public static function get_submitted_users_table(){
        $users = self::get_users();
       
        $table = "<div class='cj_users'>
                    <h3>Subscribed users</h3>
                    <table class='cjusers' style='border-collapse:collapse'>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                        </tr>";
      foreach( $users as $user ){
        $rows = "<tr>";
        $rows .= "<td>{$user->UserName}</td>";
        $rows .= "<td>{$user->Email}</td>";
        $rows .= "<td>{$user->UserDate}</td>";
        $rows .= "<tr>";
        $table .= $rows;
      };
      
      $table .= "</table></div>";

      return $table;
    }


    /**
    * Delete table from db after plugin uninstalling
    *
    * @static
    * @return void
    */
    public static function delete_table(){
        global $wpdb;
        $query      = "DROP TABLE `cj_users`";
        $is_table   = $wpdb->query( $query );
    }
  


}
