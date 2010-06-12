<?php

class Setup
{
    public function get()
    {
        $con = new Model();
        @unlink('banco.db');
        $con->setup();
    }
}

class Home
{
    public function get()
    {
        print 'oi';
    }
}
