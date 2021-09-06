<?php

namespace App\Controller;

use App\Query\ActivityQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ActivityController extends AbstractController
{
    public function index(Request $request, MessageBusInterface $queryBus)
    {
        $aggregations = $request->query->get('aggregations') ?? [];

        $activityQuery = new ActivityQuery($aggregations);
        $envelope = $queryBus->dispatch($activityQuery);
        $handledStamp = $envelope->last(HandledStamp::class);

        $activityList = $handledStamp->getResult();

        return $this->render('index.html.twig', [
            'activity_list' => $activityList,
            'aggregations' => $aggregations,
        ]);
    }
}
