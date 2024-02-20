<?php

return [

    /*
     * Define the table which is used in the database to retrieve the users
     */

    'users_table' => 'users',

    /*
     * Define the table column type which is used in the table schema for
     * the id of the user
     *
     * Options: increments, bigIncrements, uuid
     * Default: bigIncrements
     */

    'users_table_column_type' => 'bigIncrements',

    /*
     * Define the name of the column which is used in the foreign key reference
     * to the id of the user
     */

    'candidates_table_column_id_name' => 'candidate_id',
    'jobs_table_column_id_name' => 'job_id',
    'skills_table_column_id_name' => 'skill_id',


    /*
     * Define the model which is used for the relationships on your models
     */

    'candidates_model' => \App\Models\Candidate::class,
    'jobs_model' => \App\Models\Job::class,
    'skills_model' => \App\Models\Skill::class,

    /*
     * Define the column which is used in the database to save the user's id
     * which created the model.
     */

    'created_by_column' => 'created_by',

    /*
     * Define the column which is used in the database to save the user's id
     * which updated the model.
     */

    'updated_by_column' => 'updated_by',

    /*
     * Define the column which is used in the database to save the user's id
     * which deleted the model.
     */

    'deleted_by_column' => 'deleted_by',

];
