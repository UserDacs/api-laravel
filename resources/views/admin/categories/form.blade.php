<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="category_name">Category</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $category->category_name ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $category->description ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100px me-5px">Save</button>
        <a href="javascript:;" class="btn btn-default w-100px">Cancel</a>
    </div>
    <div class="col-md-3">

    </div>
</div>
