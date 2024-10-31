<?php
namespace ypl;

require_once dirname(__FILE__).'/Results.php';


class classicResults extends Results {

    private function getMainContent() {
        $answers = $this->getPoll()->getAnswers();
        $voteResults = $this->voteResults;
        ob_start();
        foreach ($answers as $answer):
            $voteNumber = $voteResults[$answer];
            $votePercent = $this->getPercent($voteNumber);
            ?>
        <div>
            <label><?php echo $answer; ?></label><span class="vote-result"><?php echo $votePercent;?>%</span>
            <div class="ypl-meter">
                <span style="width:<?php echo $votePercent;?>%;"><span class="ypl-progress"></span></span>
            </div>
        </div>
        <?php
            endforeach;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function resultView() {
        $mainContent = $this->getMainContent();
        $view = $this->render($mainContent);
        $view .= $this->renderStyles();

        return $view;
    }
}