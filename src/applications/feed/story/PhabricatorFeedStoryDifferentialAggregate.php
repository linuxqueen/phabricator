<?php

final class PhabricatorFeedStoryDifferentialAggregate
  extends PhabricatorFeedStoryAggregate {

  public function renderView() {
    $data = $this->getStoryData();

    $task_link = $this->linkTo($data->getValue('revision_phid'));

    $authors = $this->getAuthorPHIDs();

    // TODO: These aren't really translatable because linkTo() returns a
    // string, not an object with a gender.

    switch (count($authors)) {
      case 1:
        $author = $this->linkTo(array_shift($authors));
        $title = pht(
          '%s made multiple updates to %s',
          $author,
          $task_link);
        break;
      case 2:
        $author1 = $this->linkTo(array_shift($authors));
        $author2 = $this->linkTo(array_shift($authors));
        $title = pht(
          '%s and %s made multiple updates to %s',
          $author1,
          $author2,
          $task_link);
        break;
      case 3:
        $author1 = $this->linkTo(array_shift($authors));
        $author2 = $this->linkTo(array_shift($authors));
        $author3 = $this->linkTo(array_shift($authors));
        $title = pht(
          '%s, %s, and %s made multiple updates to %s',
          $author1,
          $author2,
          $author3,
          $task_link);
        break;
      default:
        $author1 = $this->linkTo(array_shift($authors));
        $author2 = $this->linkTo(array_shift($authors));
        $others  = count($authors);
        $title = pht(
          '%s, %s, and %d others made multiple updates to %s',
          $author1,
          $author2,
          $others,
          $task_link);
        break;
    }

    $view = new PhabricatorFeedStoryView();
    $view->setAppIcon('differential-dark');
    $view->setEpoch($this->getEpoch());
    $view->setViewed($this->getHasViewed());
    $view->setTitle($title);

    $href = $this->getHandle($data->getValue('revision_phid'))->getURI();
    $view->setHref($href);

    return $view;
  }

}
