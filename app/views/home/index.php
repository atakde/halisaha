<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4">
                        <?php if (!empty($this->lastMatch)) : ?>
                            <input type="hidden" id="matchId" name="matchId" value="<?= $this->lastMatch["id"] ?>">
                            <p class="mb-2">
                                <span class="h3 me-2 match_title"><?= $this->lastMatch['match_title'] ?></span>
                                <span class="badge <?= $this->lastMatch['status'] == 1 ? 'bg-success' : 'bg-danger' ?> float-end"><?= $this->lastMatch['status'] == 1 ? 'OPEN' : 'CLOSED' ?></span>
                                <span class="match-settings float-end mx-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill align-text-top" viewBox="0 0 16 16">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                    </svg>
                                </span>
                                <span class="match-settings float-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt align-text-top" viewBox="0 0 16 16">
                                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>
                                </span>
                            </p>
                            <p class="text-muted pb-2 match_date"><?= $this->lastMatch['match_date'] ?><span class="text-muted mx-2" style="color: #a2aab7;"><span class="participant-count"><?= $this->lastMatch['participant_count'] ?></span>/<span class="participant-limit"><?= $this->lastMatch['participant_limit'] ?></span></span></p>
                            <?php if ($this->lastMatch['status'] == 1) : ?>
                                <div class="input-group mb-3">
                                    <input type="text" id="player-name" class="form-control form-control-lg" placeholder="Name" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-lg ms-2" id="add-player-btn">Add</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <ul class="list-group mb-0 player-list">
                                <?php foreach ($this->lastMatch['players'] as $each) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" value="" aria-label="..." />
                                            <?= $each['name'] ?>
                                        </div>
                                        <a data-mdb-toggle="tooltip" title="Remove item">
                                            <em class="remove-player" data-id="<?= $each['id'] ?>" style="cursor: pointer;">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Match Settings</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="match_title" class="col-form-label">Title:</label>
                        <input type="text" class="form-control" value="<?= $this->lastMatch['match_title'] ?>" id="match_title">
                    </div>
                    <div class="form-group">
                        <label for="match_location" class="col-form-label">Location:</label>
                        <input type="text" class="form-control" value="<?= $this->lastMatch['match_location'] ?>" id="match_location">
                    </div>
                    <div class="form-group">
                        <label for="participant_limit" class="col-form-label">Limit:</label>
                        <input type="number" class="form-control" value="<?= $this->lastMatch['participant_limit'] ?>" id="participant_limit" disabled>
                    </div>
                    <div class="form-group">
                        <label for="match_date" class="col-form-label">Date:</label>
                        <input type="datetime-local" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($this->lastMatch['match_date'])) ?>" id="match_date"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="update-settings-btn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
