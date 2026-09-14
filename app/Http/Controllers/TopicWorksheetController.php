<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Worksheets\WorksheetBuilder;
use Symfony\Component\HttpFoundation\Response;

class TopicWorksheetController extends Controller
{
    public function __invoke(Subject $subject, TopicArea $topicArea, Topic $topic, WorksheetBuilder $builder): Response
    {
        return $builder->build($topic)->download($builder->filename($topic));
    }
}
