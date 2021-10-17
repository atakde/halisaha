<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4">
                        <?php if (!empty($this->lastMatch)) : ?>
                            <input type="hidden" id="matchId" name="matchId" value="<?= $this->lastMatch["id"] ?>">
                            <p class="mb-2"><span class="h2 me-2">Match Squad</span> <span class="badge <?= $this->lastMatch['status'] == 1 ? 'bg-success' : 'bg-danger' ?> float-end"><?= $this->lastMatch['status'] == 1 ? 'OPEN' : 'CLOSED' ?></span></p>
                            <p class="text-muted pb-2"><?= $this->lastMatch['match_date'] ?><span class="text-muted mx-2" style="color: #a2aab7;"><?= $this->lastMatch['participant_count'] . "/" . $this->lastMatch['participant_limit'] ?></span></p>
                            <?php if ($this->lastMatch['status'] == 1) : ?>
                                <div class="input-group mb-3">
                                    <input type="text" id="player-name" class="form-control form-control-lg" placeholder="Name" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-lg ms-2" id="add-player-btn">Add</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <ul class="list-group mb-0">
                                <?php foreach ($this->lastMatch['players'] as $each) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" value="" aria-label="..." />
                                            <?= $each['name'] ?>
                                        </div>
                                        <a data-mdb-toggle="tooltip" title="Remove item">
                                            <em class="remove-player" data-id="<?= $each['id'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" fill="#000" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" fill="#000" />
                                                </svg>
                                            </em>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <div class="text-center">
                                <p>No active match for now.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>