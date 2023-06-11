@csrf

<label class="uppercase text-gray-700 text-xs">Product</label>
<span class="text-xs text-red-600"> @error('product') {{ $message }} @enderror</span>
<input type="text" name="product" class="rounded border-gray-200 w-full mb-4" value="{{ $product->product }}">

<label class="uppercase text-gray-700 text-xs">Price</label>
<span class="text-xs text-red-600"> @error('price') {{ $message }} @enderror</span>
<input type="text" name="price" class="rounded border-gray-200 w-full mb-4" value="{{ $product->price }}">

<label class="uppercase text-gray-700 text-xs">Description</label>
<span class="text-xs text-red-600"> @error('description') {{ $message }} @enderror</span>
<input type="text" name="description" class="rounded border-gray-200 w-full mb-4" value="{{ $product->description }}">


<div class="flex items-center justify-center w-full">
    <label class="flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group">
         <div class="flex flex-col items-center justify-center pt-7">
                <p class="text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-eider">Insert product image</p>
         </div>
         <input type='file' name="image" accept="image/*" value="{{ $product->image }}"/>
    </label>
</div>


<div class="flex justify-between items-center">
    <a href="{{ route('products.index') }}" class="text-indigo-600">Back</a>
    <input type="submit" value="Send" class="bg-gray-800 text-white rounded px-4 py-2">
</div>