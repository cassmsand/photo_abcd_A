<div id="viewProfileModal" class="modal fade" role="dialog" aria-labelledby="viewUserProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">View User's Blogs</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- User details go here -->
                <p id="profile-username"></p>

                 <!-- Search Form -->
                <div id="profileSearchContainer">
                    <input type="text" id="profileSearchInput" placeholder="Search by title...">
                    <label for="startDate">Sort by creation date:</label>
                    <input type="date" id="profileStartDate" placeholder="Start Date" style="margin-left: 5px;">
                    <input type="date" id="profileEndDate" placeholder="End Date">
                    <button id="profileSearchButton">Search</button>
                </div>

                <div id="profileSortContainer">
                    <label for="sortOrder">Display:</label>
                    <select id="profileSortOrder">
                        <option value="asc">Alphabetically (A-Z)</option>
                        <option value="desc">Alphabetically (Z-A)</option>
                        <option value="date_asc">Event Date (Oldest to Newest)</option>
                        <option value="date_des">Event Date (Newest to Oldest)</option>
                    </select>
                </div>

                <!-- Posts Container -->
                <div id="profilePostsContainer"></div>

                 <!-- Modal for Photo Only Grid View -->
                <div class="modal fade" id="profile-card-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 id="profile-card-modal-title"></h3>
                            </div>
                            <div class="modal-body">
                                <img src="" alt="" id="profile-card-modal-img" class="img-fluid">
                                <p class="lead" id="profile-card-modal-desc"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>