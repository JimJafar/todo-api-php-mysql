<?php

abstract class Config {
    /**
     * Returns the base URL
     * @return String
     */
    static function base_url() {
        return 'http://'.$_SERVER['HTTP_HOST'].'/';
    }

    /**
     * Generates a REST request URL
     * @param $path The path to the method
     * @return String
     */
    static function request_url($path) {
        return Config::base_url().$path;
    }

    /**
     * The DB hostname
     */
    const DB_host = 'localhost';

    /**
     * The DB username
     */
    const DB_user = 'todo_user';

    /**
     * The DB password
     */
    const DB_password = 'letmein!';

    /**
     * The DB name
     */
    const DB_database = 'todo_db';

    /**
     * The DB port
     */
    const DB_port = 3306;

    /**
     * The DB socket
     */
    const DB_socket = '';
}
