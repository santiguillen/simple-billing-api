<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class AddPaginationHeaders implements EventSubscriberInterface
{
    public function addHeaders(FilterResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (($data = $request->attributes->get('data')) && $data instanceof Paginator) {
            $from = $data->count() ? ($data->getCurrentPage() - 1) * $data->getItemsPerPage() : 0;
            $to = $data->getCurrentPage() < $data->getLastPage() ? $data->getCurrentPage() * $data->getItemsPerPage() : $data->getTotalItems();

            $response = $event->getResponse();
            $response->headers->add([
                'Pagination-Content-Range'  => \sprintf('%u-%u/%u', $from, $to, $data->getTotalItems()),
                'Pagination-Items-Per-Page' => $data->getItemsPerPage(),
                'Pagination-Total-Items'    => $data->getTotalItems(),
                'Pagination-Current-Page'   => $data->getCurrentPage(),
                'Pagination-Last-Page'      => $data->getLastPage(),
            ]);

        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addHeaders',
        ];
    }
}