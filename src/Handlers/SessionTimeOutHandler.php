<?php

namespace Src\Handlers;

use DateTime;
use Src\Http\Session;

class SessionTimeOutHandler
{
    private Session $session;
    private int $duration;

    public function __construct(Session $session, int $timeOutDuration)
    {
        $this->session = $session;
        $this->duration = $timeOutDuration;
    }

    public function checkTimeOut(): bool
    {
//       This is necessary for converting it to time stamp
        $lastActive = DateTime::createFromFormat('Y-m-d H:i:s', $this->session->get('LAST_ACTIVE'));

        $lastActiveTimestamp = $lastActive->getTimestamp();
        $currentTime = (new DateTime())->getTimestamp();

        return $currentTime - $this->duration < $lastActiveTimestamp;
    }
}