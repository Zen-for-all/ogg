<?php
/**
 * @var string $title The title displayed on the page, representing the main heading.
 */
?>

<h2 class="pb-5"><?= htmlspecialchars($title) ?></h2>

<div class="container mt-5">
  <div class="accordion" id="exampleAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
          <p>Что такое проект Lucid?</p>
        </button>
      </h2>
      <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#exampleAccordion">
        <div class="accordion-body">
          Ответ 1
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="heading2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
          <p>Какая цель проекта Lucid?</p>
        </button>
      </h2>
      <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#exampleAccordion">
        <div class="accordion-body">
          Ответ 2
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="heading3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
          <p>Какая польза мне от проекта Lucid?</p>
        </button>
      </h2>
      <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#exampleAccordion">
        <div class="accordion-body">
          Ответ 3
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="heading4">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
          <p>В чем разница LucidNote и LucidNet?</p>
        </button>
      </h2>
      <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#exampleAccordion">
        <div class="accordion-body">
          Ответ 4
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="heading5">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
          <p>Какой функционал есть в проекте LucidNote?</p>
        </button>
      </h2>
      <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#exampleAccordion">
        <div class="accordion-body">
          Ответ 5
        </div>
      </div>
    </div>

  </div>
</div>