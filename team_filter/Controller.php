<?php

    //include script in column
    $table->editColumn('team_nazov', function ($row) {
        return '<a href="#" onclick="selectOption(\'' . ($row->team ? $row->team->nazov : '') . '\')">' . ($row->team ? $row->team->nazov : '') . '</a>';
    });

    //make column raw
    $table->rawColumns(['actions', 'placeholder', 'team', 'dok_typ', 'dok_kat', 'document', 'accounting', 'title', 'team_nazov']);
