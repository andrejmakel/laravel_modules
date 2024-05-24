<?php

class DodavatelController
{

    public function index()
    {
        $table = 'datatables';
        $table->addColumn('dodavatel_dodavatel', function ($row) {
            return '<a href="#" onclick="dodavatelInfo(\'' . ($row->dodavatel ? $row->dodavatel->id : '') . '\')"><i class="bi bi-bank" style="padding-right: 10px; font-size: 12px; color: rgb(140, 140, 140); position: relative; top: -1px;"></i></a> <a href="#" onclick="selectOption(\'' . ($row->dodavatel ? $row->dodavatel->skratka : '') . '\')">' . ($row->dodavatel ? $row->dodavatel->skratka : '') . '</a>';
        });
    }



    public function getDodavatelInfo($dodavatel_id)
    {
        $dodavatel = Dodavatel::find($dodavatel_id);
        return response()->json(
            [
                'name' => $dodavatel->dodavatel,
                'id' => $dodavatel->id,
            ]
        );
    }

}