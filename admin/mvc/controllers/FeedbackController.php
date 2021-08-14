<?php

class FeedbackController extends controllers
{
    protected $feedback;

    public function listFeedback()
    {
        $this->feedback = $this->models('Feedback');
        $dataViews = [
            'views' => 'feedbacks/list',
            'feedback' => $this->feedback->listFeedback()
        ];
        $this->views('layouts/master', $dataViews);
    }

    public function updateStatusFB()
    {
        $data = $_POST;
        $this->feedback = $this->models("Feedback")->updateStatus($data);
    }

    public function deleteFB()
    {
        $id = $_POST['fbID'];
        $this->feedback = $this->models("Feedback")->deleteFB($id);
    }
}