/* This example script does the following:
   
   1. Get available balance in your account for Dogecoin, or Litecoin, or Bitcoin, etc.
   2. Create an address labeled 'shibetime1' on the account if it does not already exist
   3. Withdraw 1% of total available balance in your account, and send it to the address labeled 'shibetime1'
   
   IMPORTANT! Specify your own API Key and Secret PIN in this code. Keep your Secret PIN safe at all times.

   Contact support@block.io for any help with this.
*/

<?php
require_once 'path/to/block_io.php';

/* Replace the $apiKey with the API Key from your Block.io Wallet. A different API key exists for Dogecoin, Dogecoin Testnet, Litecoin, Litecoin Testnet, etc. */
$apiKey = 'YourDogecoinTestnetAPIKey';
$pin = 'YourSecretPIN';
$version = 2; // the API version

$block_io = new BlockIo($apiKey, $pin, $version);

echo "*** Getting account balance\n";

$getBalanceInfo = "";

try {
    $getBalanceInfo = $block_io->get_balance();
    
    echo "!!! Using Network: ".$getBalanceInfo->data->network."\n";
    echo "Available Amount: ".$getBalanceInfo->data->available_balance." ".$getBalanceInfo->data->network."\n";
} catch (Exception $e) {
   echo $e->getMessage() . "\n";
}

echo "\n\n";


echo "*** Create new address\n";

$getNewAddressInfo = "";

try {
    $getNewAddressInfo = $block_io->get_new_address(array('label' => 'shibetime1'));

    echo "New Address: ".$getNewAddressInfo->data->address."\n";
    echo "Label: ".$getNewAddressInfo->data->label."\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

echo "\n\n";

try {
    echo "Getting address for Label='shibetime1'\n";
    $getAddressInfo = $block_io->get_address_by_label(array('label' => 'shibetime1'));
    echo "Status: ".$getAddressInfo->status."\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

echo "Label has Address: " . $block_io->get_address_by_label(array('label' => 'shibetime1'))->data->address . "\n";

echo "\n\n";

echo "***Send 1% of coins on my account to the address labeled 'shibetime1'\n";

$sendAmount = floatval($getBalanceInfo->data->available_balance)*0.01;

echo "Available Amount: ".$getBalanceInfo->data->available_balance." ".$getBalanceInfo->data->network."\n";

echo "Withdrawing 1% of Available Amount: ".$sendAmount." ".$getBalanceInfo->data->network."\n";

try {
    $withdrawInfo = $block_io->withdraw(array('to_address' => $getAddressInfo->data->address, 'amount' => $sendAmount));
    echo "Status: ".$withdrawInfo->status."\n";

    echo "Executed Transaction ID: ".$withdrawInfo->data->txid."\n";
    echo "Network Fee Charged: ".$withdrawInfo->data->network_fee." ".$withdrawInfo->data->network."\n";
} catch (Exception $e) {
   echo $e->getMessage() . "\n";
}

?>
