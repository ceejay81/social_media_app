<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to FakeBook, <?= session()->get('username') ?>!</h1>

            <div class="card">
                <div class="card-header">
                    <h2>News Feed</h2>
                </div>
                <div class="card-body">
                    <!-- Feed Content Here -->
                    <p>Here’s what’s happening...</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Your Posts</h2>
                </div>
                <div class="card-body">
                    <!-- User’s Posts Here -->
                    <p>Manage your posts...</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Messages</h2>
                </div>
                <div class="card-body">
                    <!-- Messages Content Here -->
                    <p>Your recent messages...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
