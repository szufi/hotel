<?php
declare(strict_types=1);

namespace Hotel\Application\Console;


use Hotel\Application\Model\Reservation;
use Psr\Log\LoggerInterface;
use Zend\Mvc\Console\Controller\AbstractConsoleController;

class StatusController extends AbstractConsoleController
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function indexAction(): void
    {
        $this->logger->info('Script "Reservation status updater" has started');

        /** @var Reservation[] $reservations */
        $reservations = Reservation::{'where'}('status', '=', 'NEW')->get();

        foreach ($reservations as $reservation) {
            if ($reservation->hasExpired()) {
                $this->logger->info("Reservation " . $reservation->getAttribute('id') . " has expired");

                $reservation->setAttribute('status', "EXPIRED");
                $reservation->save();
            }
        }

        $this->logger->info('Script "Reservation status updater" has finished');
    }
}