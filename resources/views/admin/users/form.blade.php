<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image_path">Profile Image</label>
            <input type="file" name="image_path" class="form-control">
        </div>
        @if (!empty($user->image_path))
        <div class="mb-2">
            <img src="{{ $user->image_path }}" alt="Profile Image" width="100">
        </div>
        @endif

    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="address_street">Street</label>
            <input type="text" name="address_street" class="form-control" value="{{ old('address_street', $user->address_street ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="address_city">City</label>
            <input type="text" name="address_city" class="form-control" value="{{ old('address_city', $user->address_city ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="address_state">State</label>
            <input type="text" name="address_state" class="form-control" value="{{ old('address_state', $user->address_state ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="address_zip_code">Zip Code</label>
            <input type="text" name="address_zip_code" class="form-control" value="{{ old('address_zip_code', $user->address_zip_code ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="role">Role</label>
            <select name="role" class="form-control">
                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="provider" {{ old('role', $user->role ?? '') == 'provider' ? 'selected' : '' }}>Shop Owner</option>
                <option value="technician" {{ old('role', $user->role ?? '') == 'technician' ? 'selected' : '' }}>Technician</option>
                <option value="customer" {{ old('role', $user->role ?? '') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="mb-3" style="display: none">
            <label for="mobile_auth">Mobile Auth</label>
            <input type="text" name="mobile_auth" class="form-control" value="{{ old('mobile_auth', $user->mobile_auth ?? 'unauthenticated') }}">
        </div>
    </div>
</div>
