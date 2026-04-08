<div>
    @error($model)
        <span class="font-danger">{{ $message }}</span>
    @enderror
    @error($model.'.*')
        <span class="font-danger">{{ $message }}</span>
    @enderror
</div>
