<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="category_name">Select shop </label>
            <select name="shop_id" id="shop_id" class="form-control">
                @foreach (get_user_with_shop() as $user)
                    <option value="{{ $user->shop_id }}"
                        {{ old('shop_id', $service->shop_id ?? '') == $user->shop_id ? 'selected' : '' }}>
                        {{ $user->shop_name }} - {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">

            <label for="technician_id">Select technician </label>
            <select name="technician_id" id="technician_id" class="form-control">
                @foreach (get_users_not_technicians() as $user)
                    <option value="{{ $user->technician_id }}"
                        {{ old('user_id', $service->technician_id ?? '') == $user->technician_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">

            <label for="category_id">Select category </label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach (get_category() as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $service->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="service_name">Service name</label>
            <input type="text" name="service_name" class="form-control" value="{{ old('service_name', $service->service_name ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $service->price ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $service->description ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image_path">Image</label>
            <input type="file" name="image_path" class="form-control">
        </div>
        @if (!empty($service->image_path))
        <div class="mb-2">
            <img src="{{ $service->image_path }}" alt="Image" width="100">
        </div>
        @endif
        <button type="submit" class="btn btn-primary w-100px me-5px">Save</button>
        <a href="/admin-services" class="btn btn-default w-100px">Cancel</a>
    </div>
    <div class="col-md-3">

    </div>
</div>
