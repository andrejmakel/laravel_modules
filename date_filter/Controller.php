<?php

//select records when the filter is disabled
$query = Doklady::with(['team', 'sablona', 'dodavatel', 'typ', 'doc_source', 'my_email', 'period', 'predkontacia', 'clenenie_dph', 'clnenie_kv', 'currency', 'paid_from'])->select(sprintf('%s.*', (new Doklady)->table));

//select records when the filter is enabled
if ($request->filled('from_date') && $request->filled('to_date') && $request->input('checkboxValue') == 1) {
    $query = Doklady::whereBetween('date', [$request->from_date, $request->to_date]);
}