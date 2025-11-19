<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleDtoInterface;
use Vigihdev\WpPostType\Contracts\PostTypeLabelsInterface;

/**
 * DTO untuk Post Type Labels
 */
final class PostTypeLabelsDto implements ArrayAbleDtoInterface, PostTypeLabelsInterface
{

    public function __construct(
        private string $name,
        private string $singularName,
        private string $menuName,
        private string $nameAdminBar,
        private string $addNew,
        private string $addNewItem,
        private string $newItem,
        private string $editItem,
        private string $viewItem,
        private string $allItems,
        private string $searchItems,
        private string $parentItemColon,
        private string $notFound,
        private string $notFoundInTrash,
        private string $featuredImage,
        private string $setFeaturedImage,
        private string $removeFeaturedImage,
        private string $useFeaturedImage,
        private string $archives,
        private string $insertIntoItem,
        private string $uploadedToThisItem,
        private string $filterItemsList,
        private string $itemsListNavigation,
        private string $itemsList,
        private string $textdomain = 'textdomain'
    ) {}

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'name'                  => _x($this->name, 'Post type general name', $this->textdomain),
            'singular_name'         => _x($this->singularName, 'Post type singular name', $this->textdomain),
            'menu_name'             => _x($this->menuName, 'Admin Menu text', $this->textdomain),
            'name_admin_bar'        => _x($this->nameAdminBar, 'Add New on Toolbar', $this->textdomain),
            'add_new'               => __($this->addNew, $this->textdomain),
            'add_new_item'          => __($this->addNewItem, $this->textdomain),
            'new_item'              => __($this->newItem, $this->textdomain),
            'edit_item'             => __($this->editItem, $this->textdomain),
            'view_item'             => __($this->viewItem, $this->textdomain),
            'all_items'             => __($this->allItems, $this->textdomain),
            'search_items'          => __($this->searchItems, $this->textdomain),
            'parent_item_colon'     => __($this->parentItemColon, $this->textdomain),
            'not_found'             => __($this->notFound, $this->textdomain),
            'not_found_in_trash'    => __($this->notFoundInTrash, $this->textdomain),
            'featured_image'        => _x($this->featuredImage, 'Overrides the "Featured Image" phrase', $this->textdomain),
            'set_featured_image'    => _x($this->setFeaturedImage, 'Overrides the "Set featured image" phrase', $this->textdomain),
            'remove_featured_image' => _x($this->removeFeaturedImage, 'Overrides the "Remove featured image" phrase', $this->textdomain),
            'use_featured_image'    => _x($this->useFeaturedImage, 'Overrides the "Use as featured image" phrase', $this->textdomain),
            'archives'              => _x($this->archives, 'The post type archive label used in nav menus', $this->textdomain),
            'insert_into_item'      => _x($this->insertIntoItem, 'Overrides the "Insert into post" phrase', $this->textdomain),
            'uploaded_to_this_item' => _x($this->uploadedToThisItem, 'Overrides the "Uploaded to this post" phrase', $this->textdomain),
            'filter_items_list'     => _x($this->filterItemsList, 'Screen reader text for the filter links', $this->textdomain),
            'items_list_navigation' => _x($this->itemsListNavigation, 'Screen reader text for the pagination', $this->textdomain),
            'items_list'            => _x($this->itemsList, 'Screen reader text for the items list', $this->textdomain),
        ];
    }

    /**
     * Create DTO from array
     */
    public static function fromArray(array $data): static
    {
        return new self(
            name: $data['name'] ?? '',
            singularName: $data['singular_name'] ?? '',
            menuName: $data['menu_name'] ?? '',
            nameAdminBar: $data['name_admin_bar'] ?? '',
            addNew: $data['add_new'] ?? 'Add New',
            addNewItem: $data['add_new_item'] ?? '',
            newItem: $data['new_item'] ?? '',
            editItem: $data['edit_item'] ?? '',
            viewItem: $data['view_item'] ?? '',
            allItems: $data['all_items'] ?? '',
            searchItems: $data['search_items'] ?? '',
            parentItemColon: $data['parent_item_colon'] ?? '',
            notFound: $data['not_found'] ?? '',
            notFoundInTrash: $data['not_found_in_trash'] ?? '',
            featuredImage: $data['featured_image'] ?? '',
            setFeaturedImage: $data['set_featured_image'] ?? '',
            removeFeaturedImage: $data['remove_featured_image'] ?? '',
            useFeaturedImage: $data['use_featured_image'] ?? '',
            archives: $data['archives'] ?? '',
            insertIntoItem: $data['insert_into_item'] ?? '',
            uploadedToThisItem: $data['uploaded_to_this_item'] ?? '',
            filterItemsList: $data['filter_items_list'] ?? '',
            itemsListNavigation: $data['items_list_navigation'] ?? '',
            itemsList: $data['items_list'] ?? '',
            textdomain: $data['textdomain'] ?? 'textdomain'
        );
    }

    /**
     * Factory method untuk create labels dengan singular & plural
     */
    public static function create(
        string $singular,
        string $plural,
        string $textdomain = 'textdomain'
    ): self {
        return new self(
            name: $plural,
            singularName: $singular,
            menuName: $plural,
            nameAdminBar: $singular,
            addNew: 'Add New',
            addNewItem: "Add New {$singular}",
            newItem: "New {$singular}",
            editItem: "Edit {$singular}",
            viewItem: "View {$singular}",
            allItems: "All {$plural}",
            searchItems: "Search {$plural}",
            parentItemColon: "Parent {$plural}:",
            notFound: "No {$plural} found.",
            notFoundInTrash: "No {$plural} found in Trash.",
            featuredImage: "{$singular} Cover Image",
            setFeaturedImage: 'Set cover image',
            removeFeaturedImage: 'Remove cover image',
            useFeaturedImage: 'Use as cover image',
            archives: "{$singular} archives",
            insertIntoItem: "Insert into {$singular}",
            uploadedToThisItem: "Uploaded to this {$singular}",
            filterItemsList: "Filter {$plural} list",
            itemsListNavigation: "{$plural} list navigation",
            itemsList: "{$plural} list",
            textdomain: $textdomain
        );
    }
}
