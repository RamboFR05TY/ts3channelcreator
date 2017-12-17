<?php
include("config.php");
/*Created by : RamboFR05TY
Last Updated : 17/04/2017
Built for RSA Gaming
email : bruce@rsagaming.co.za*/

try
{

    TeamSpeak3::init();
    $ts3 = TeamSpeak3::factory("serverquery://{$config["Username"]}:{$config["Password"]}@{$config["serverIP"]}:{$config["qPort"]}/?server_port={$config["sPort"]}&nickname={$config["BotName"]}");
    while (true)
    {
        foreach($ts3->channelList() as $channel)
        {
            if ($channel['cid'] == $config['ChannelToJoin'] && $channel["total_clients"] > 0)
            {
                foreach($ts3->clientList() as $client)
                {
                    {
                        if ($client['cid'] == $config['ChannelToJoin'] && $client['client_type'] == 0)
                        {
                            if(strpos($client['client_servergroups'], $config['ServerGroupToIgnore']) === false)
                            {

                                channelCreation($client,$config, $ts3 );

                            }
                        }
                    }
                }
            }
        }
        $ts3->channelListReset();
        $ts3->clientListReset();
        usleep(500000);
    }
}
catch(Exception $ex)
{
    echo "ErrorID: <b>" . $ex->getCode() . "</b>; Error Message: <b>" . $ex->getMessage() . "</b>;";
}
function channelCreation($client, $config , $ts3)
{
    $channel =  $ts3->channelGetById($config['ChannelToBeSub'])['channel_name'] . "/" . $client['client_nickname'] . "'s Channel";
    $channelname =  $client['client_nickname'] . "'s Channel";
    $pass = randomString();
    $clientnickname = $client['client_nickname'];
    $clientuid = $client['client_unique_identifier'];
    $clientip = $client['connection_client_ip'];
    $link = "ts3server://{$config['TSDomain']}?port={$config['sPort']}&channel=" . rawurlencode($channel) . "&channepassword={$pass}";
    $alternativeLink = "ts3server://" . $config['TSDomain'] . "?port=" . $config['sPort'] . "&channel=".urlencode($channel) . "&channelpassword=" . $pass;
//Create Primary Channel
    $cid = $ts3->channelCreate([
        "channel_name" => $channelname,
        "channel_password" => $pass,
        "channel_flag_permanent" => "1",
        "channel_description" => '[center][b][u]' . $client['client_nickname'] . "'s Channel" . '[/u][/b][/center][hr][b][list][*]Date: ' . date("[d-m-Y - H:i:s]", time()) . '[*]Owner:  [URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . '~' . rawurlencode($client['client_nickname']) . ']' . $client['client_nickname']. '[/URL] [/list][/b]',
        "cpid" => $config['ChannelToBeSub']

    ]);

//Creating Sub Channel 1
    $scid = $ts3->channelCreate([
        "channel_name" => "Sub 1",
        "channel_password" => $pass,
        "channel_flag_permanent" => "1",
        "channel_description" => '[center][b][u]' . $client['client_nickname'] . "'s Channel" . '[/u][/b][/center][hr][b][list][*]Date: ' . date("[d-m-Y - H:i:s]", time()) . '[*]Owner:  [URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . '~' . rawurlencode($client['client_nickname']) . ']' . $client['client_nickname']. '[/URL] [/list][/b]',    
        "cpid" => $cid
    ]);
//Creating Sub Channel 2
    $scid = $ts3->channelCreate([
    "channel_name" => "Sub 2",
    "channel_password" => $pass,
    "channel_flag_permanent" => "1",
    "channel_description" => '[center][b][u]' . $client['client_nickname'] . "'s Channel" . '[/u][/b][/center][hr][b][list][*]Date: ' . date("[d-m-Y - H:i:s]", time()) . '[*]Owner:  [URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . '~' . rawurlencode($client['client_nickname']) . ']' . $client['client_nickname']. '[/URL] [/list][/b]',    
    "cpid" => $cid
    ]);
//Creating Sub Channel 3
$scid = $ts3->channelCreate([
    "channel_name" => "Sub 3",
    "channel_password" => $pass,
    "channel_flag_permanent" => "1",
    "channel_description" => '[center][b][u]' . $client['client_nickname'] . "'s Channel" . '[/u][/b][/center][hr][b][list][*]Date: ' . date("[d-m-Y - H:i:s]", time()) . '[*]Owner:  [URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . '~' . rawurlencode($client['client_nickname']) . ']' . $client['client_nickname']. '[/URL] [/list][/b]',    
    "cpid" => $cid
]);
	echo '[URL=client://' . $client['clid'] . '/' . $client['client_unique_identifier'] . '~' . rawurlencode($client['client_nickname']) . ']' . $client['client_nickname']. '[/URL]';
    $client->move($cid);
    $client->setChannelGroup($cid, $config['ChannelAdmin']);
    $client->message("Hello " . $client['client_nickname'] . 
    ".\n This Channel was created for you and your Friends. It's Password is: [B][ " . $pass . " ][/B]. 
    \n\n If you wish to invite anyone to your Channel, give them this link: 
    \n Invitation-Link:  [URL=" . $link . "] Invitation-Link[/URL] Right Click me and Say Copy Link to clipboard   
    \n\n Enjoy your Stay here.");
    }
function randomString($length = 12)
{
    $str = "";
    $characters = array_merge(range('A', 'z') , range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++)
    {
        $rand = mt_rand(0, $max);
        $str.= $characters[$rand];
    }
    return $str;
}


