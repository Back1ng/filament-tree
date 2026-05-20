@php
    $modelClass = $component::getModel();
    if($modelClass instanceof \Kalnoy\Nestedset\QueryBuilder) {
        $modelClass = $modelClass->getModel()::class;
    }
@endphp

<li data-id="{{ $row->getKey() }}">
    <div class="tree-row">
        <div class="tree-row-handler">
            @if($row->children->isNotEmpty())
                <x-filament::icon
                    icon="heroicon-o-chevron-{{ $collapsed ? 'right' : 'down' }}"
                    class="tree-row-toggle"
                    wire:click="$toggle('collapsed')"
                />
            @endif
            <x-filament::icon
                icon="heroicon-o-ellipsis-vertical"
                class="handle tree-row-grip"
            />
        </div>
        <div class="tree-row-info">
            <div class="tree-row-content">
                <div class="tree-row-title">
                    {{ $row->getAttribute($modelClass::getTreeLabelAttribute()) }}
                </div>
                @if(method_exists($row, 'getTreeCaption'))
                    <div class="tree-row-caption">
                        {{ $row->getTreeCaption() }}
                    </div>
                @endif
            </div>
            <div class="tree-row-infolist">
                {{ $this->infolist }}
            </div>
        </div>
        <div class="tree-row-actions">
            <div>{{ ($this->editAction)(['id' => $row->getKey()]) }}</div>
            @if($this->canBeDeleted)
                <div>{{ ($this->deleteAction)(['id' => $row->getKey()]) }}</div>
            @endif
        </div>
    </div>

    <ul class="studio15-tree" data-id="{{ $row->getKey() }}">
        @if(!$collapsed)
            @foreach($row->children->sortBy(Kalnoy\Nestedset\NestedSet::LFT) as $child)
                <livewire:filament-tree::row
                        :component="$component"
                        :row="$child"
                        :row-id="$child->getKey()"
                        :key="Studio15\FilamentTree\Helpers::treeKey($child)"
                />
            @endforeach
        @endif
    </ul>

    <x-filament-actions::modals/>
</li>
