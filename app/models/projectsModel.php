<?php 

class projectsModel extends Model {
    protected $table = 'projects'; 
    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'status', 'color']; 
}

?>