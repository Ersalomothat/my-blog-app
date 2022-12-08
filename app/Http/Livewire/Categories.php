<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Category, SubCategory, Post};
use Illuminate\Support\Str;

class Categories extends Component
{
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode = false;

    public $subcategory_name;
    public $parent_category;
    public $selected_subcategory_id;
    public $updateSubCategoryMode = false;

    protected $listeners = [
        'resetModalForm',
        'deleteCategoryAct',
        'deleteSubCategoryAct'
    ];

    protected $rules = [
        'category_name' => 'required|unique:categories,category_name'
    ];


    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->category_name = null;
        $this->subcategory_name = null;
        $this->parent_category = null;
    }

    public function addCategory()
    {
        $this->validate();
        $category = new Category();
        $category->category_name = $this->validate()['category_name'];
        $saved = $category->save();
        if ($saved) {
            $this->dispatchBrowserEvent('hideCategoriesModal');
            $this->category_name = null;
            $this->showToastr('New category has been successfully added.', 'success');
        } else {
            $this->showToastr('Something went wrong.', 'error');
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->updateCategoryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showcategoriesModal');
    }
    public function updateCategory()
    {
        if ($this->selected_category_id) {
            $this->validate([
                'category_name' => 'required|unique:categories,category_name,' . $this->selected_category_id,
            ]);

            $category = Category::findOrFail($this->selected_category_id);
            $category->category_name = $this->category_name;
            $updated = $category->save();

            if ($updated) {
                $this->dispatchBrowserEvent('hideCategoriesModal');
                $this->updateCategoryMode = false;
                $this->showToastr('Category has been successfully updated.', 'success');
            } else {
                $this->showToastr('Something went wrong', 'error');
            }
        }
    }

    public function addSubCategory()
    {
        $this->validate([
            'parent_category' => 'required',
            'subcategory_name' => 'required|unique:sub_categories,subcategory_name',
        ]);

        $subcategory = new SubCategory();
        $subcategory->subcategory_name = $this->subcategory_name;
        $subcategory->slug = Str::slug($this->subcategory_name);
        $subcategory->parent_category = $this->parent_category;
        $saved = $subcategory->save();

        if ($saved) {
            $this->dispatchBrowserEvent('hideSubCategoriesModal');
            $this->parent_category = null;
            $this->subcategory_name = null;
            $this->showToastr('New SubCategory has been successfully added.', 'success');
        } else {
            $this->showToastr('Something went wrong', 'error');
        }
    }

    public function editSubCategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $this->selected_subcategory_id = $subcategory->id;
        $this->parent_category = $subcategory->parent_category;
        $this->subcategory_name = $subcategory->subcategory_name;
        $this->updateSubCategoryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showSubCategoriesModal');
    }

    public function updateSubCategory()
    {
        if ($this->selected_subcategory_id) {
            $this->validate([
                'parent_category' => 'required',
                'subcategory_name' => 'required|unique:sub_categories,subcategory_name,' . $this->selected_subcategory_id,
            ]);

            $subcategory = SubCategory::findOrFail($this->selected_subcategory_id);
            $subcategory->subcategory_name = $this->subcategory_name;
            $subcategory->slug = Str::slug($this->subcategory_name);
            $subcategory->parent_category = $this->parent_category;
            $updated = $subcategory->save();

            if ($updated) {
                $this->dispatchBrowserEvent('hideSubCategoriesModal');
                $this->updateSubCategoryMode = false;
                $this->showToastr('SubCategory has been successfully updated.', 'success');
            } else {
                $this->showToastr('Something went wrong', 'error');
            }
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        // $this->dispatchBrowserEvent('deleteCategory', [
        $this->emit(
            'deleteCategory',
            [
                'title' => 'Are you sure?',
                'html' => "You want to delete <b> $category->category_name </b>category",
                'id' => $id
            ]
        );
    }
    public function deleteCategoryAct(Category $category)
    {
        $subcategory = SubCategory::where('parent_category', $category->id)
            ->whereHas('posts')->with('posts')->get();
        if (!empty($subcategory) && count($subcategory) > 0) {
            $total_subs = 0;
            foreach ($subcategory as $subcat) {
                $total_subs += Post::where('category_id', $subcat->id)->get()->count();
            }
            $this->showToastr('This category has' . $total_subs . 'posts related to it, cannot be deleted', 'error');
        } else {
            SubCategory::where('parent_category', $category->id)->delete();
            $category->delete();
            $this->showToastr('This category has been deleted successfully', 'info');
        }
    }
    public function deleteSubCategory($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        // $this->dispatchBrowserEvent('deleteCategory', [
        $this->emit(
            'deleteSubCategory',
            [
                'title' => 'Are you sure?',
                'html' => "You want to delete <b> $sub_category->subcategory_name </b>sub category",
                'id' => $id
            ]
        );
    }
    public function deleteSubCategoryAct(SubCategory $subcategory)
    {
        $posts = Post::where('category_id', $subcategory->id)->get()->toArray();

        if (!empty($posts) && count($posts) > 0) {
            $this->showToastr('This sub-category has ' . count($posts) . ' posts related to it, cannot be deleted', 'error');
        } else {
            $subcategory->delete();
            $this->showToastr('This subcategory has been deleted successfully', 'info');
        }
    }

    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message
        ]);
    }

    public function render()
    {
        return view('livewire.categories', [
            'categories' => Category::orderBy('ordering', 'asc')->get(),
            'subcategories' => SubCategory::orderBy('ordering', 'asc')->get()
        ]);
    }
}
