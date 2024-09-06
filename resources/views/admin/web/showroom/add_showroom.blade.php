<button type="button" class="btn btn-dark mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal" {{$showroom_count == 8 ? 'disabled' : ''}}>
    <i class="me-2 fs-6 bi bi-plus-lg"></i>
    Add Showroom Item
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Showroom Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/add_showroom') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                            <span class="text-danger fw-light fs-xs">
                                *695x1045*
                            </span>
                        </label>
                        <input type="file" name="img" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="meal1Input" class="form-label">Product</label>
                        <input type="text" id="meal1Input" class="form-control" required
                            autocomplete="off">
                        <ul id="meal1Suggestions" class="list-group"
                            style="position: absolute; z-index: 1000; width: 100%; display: none;"></ul>
                        <input type="hidden" id="meal1Id" name="product_1_id">
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Add
                        <i class="bi bi-plus-lg"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Meal 1 input and suggestions
        handleMealInput('meal1Input', 'meal1Suggestions', 'meal1Id');

        // Meal 2 input and suggestions
        handleMealInput('meal2Input', 'meal2Suggestions', 'meal2Id');

        function handleMealInput(inputId, suggestionsId, hiddenInputId) {
            const mealInput = document.getElementById(inputId);
            const mealSuggestions = document.getElementById(suggestionsId);
            const hiddenInput = document.getElementById(hiddenInputId);

            // Assuming $meal contains an array of objects with id and name
            const meals = @json($product); // Server-side data passed to JavaScript

            mealInput.addEventListener('input', function() {
                const query = mealInput.value.toLowerCase();
                mealSuggestions.innerHTML = ''; // Clear previous suggestions

                if (query) {
                    const filteredMeals = meals.filter(meal => meal.name.toLowerCase().includes(query));
                    if (filteredMeals.length > 0) {
                        mealSuggestions.style.display = 'block';
                        filteredMeals.forEach(meal => {
                            const suggestionItem = document.createElement('li');
                            suggestionItem.textContent = meal.name;
                            suggestionItem.className = 'list-group-item list-group-item-action';
                            suggestionItem.addEventListener('click', function() {
                                mealInput.value = meal.name;
                                hiddenInput.value = meal
                                .id; // Store the selected meal's ID
                                mealSuggestions.style.display = 'none';
                            });
                            mealSuggestions.appendChild(suggestionItem);
                        });
                    } else {
                        mealSuggestions.style.display = 'none';
                    }
                } else {
                    mealSuggestions.style.display = 'none';
                }
            });

            // Hide suggestions when clicking outside the input or suggestions
            document.addEventListener('click', function(event) {
                if (!mealInput.contains(event.target) && !mealSuggestions.contains(event.target)) {
                    mealSuggestions.style.display = 'none';
                }
            });
        }
    });
</script>
