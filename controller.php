<?php

class Setup
{
    public function get()
    {
        @unlink('banco.db');
        $con = new Model();
        $con->setup();
    }
}

class Home
{
    public function get()
    {
        $con = new Model();
        $categorias = $con->categorias();
        $produtos   = $con->produtos_destaque();
    }
}
