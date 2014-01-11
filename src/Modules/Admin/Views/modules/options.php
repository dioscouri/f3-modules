<?php if ($this->event->getArgument('tabs')) { ?>

<ul class="nav nav-tabs">
    <?php foreach ((array) $this->event->getArgument('tabs') as $key => $title ) { ?>
    <li <?php if ($key == 0) { echo "class='active'"; } ?>>
        <a href="#tab-<?php echo $key; ?>" data-toggle="tab"> <?php echo $title; ?> </a>
    </li>
    <?php } ?>
</ul>

<div class="tab-content">

    <?php foreach ((array) $this->event->getArgument('content') as $key => $content ) { ?>
    <div class="tab-pane <?php if ($key == 0) { echo "active"; } ?>" id="tab-<?php echo $key; ?>">
        <?php echo $content; ?>
    </div>
    <?php } ?>
    
</div>

<?php }