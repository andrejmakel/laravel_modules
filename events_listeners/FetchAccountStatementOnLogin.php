<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\FioBankApi;
use App\Models\AccountFioOut;
use Illuminate\Support\Facades\Log;
use Exception;

class FetchAccountStatementOnLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $apiKey = env('FIO_BANK_API_KEY');

        if (!$apiKey) {
            Log::error('API key is missing');
            return;
        }

        $fioBankApi = new FioBankApi();

        try {
            $accountStatementData = $fioBankApi->getAccountStatement($apiKey);

            foreach ($accountStatementData as $statement) {
                AccountFioOut::create([
                    'user_id' => $event->user->id,
                    'account_number' => $statement['account_number'],
                    'balance' => $statement['balance'],
                    'statement_date' => $statement['statement_date'],
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error fetching account statement: ' . $e->getMessage());
        }
    }
}
