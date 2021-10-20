<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4">
                        <form action="<?= Config::get('URL') ?>match/setMatchConfiguration" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" name="match_title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Location</label>
                                <input type="text" class="form-control" name="match_location" placeholder="Enter location">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Participant Limit</label>
                                <input type="number" class="form-control" name="participant_limit" placeholder="Enter participant limit">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Date</label>
                                <input type="datetime-local" class="form-control" name="match_date" placeholder="Enter email">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
