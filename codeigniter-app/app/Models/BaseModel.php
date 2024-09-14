<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $DBGroup = 'default';

    public function __construct($db = null)
    {
        parent::__construct($db);
        $this->db = \Config\Database::connect($this->DBGroup);
    }

    public function setDatabase($database)
    {
        $this->DBGroup = $database;
        $this->db = \Config\Database::connect($this->DBGroup);
    }
}
