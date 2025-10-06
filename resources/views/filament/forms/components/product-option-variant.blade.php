<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="product_variants($wire, @js($getStatePath()))" {{ $getExtraAttributeBag() }}>
        <!-- Options -->

        <div class="border border-gray-300 rounded-lg mt-2 overflow-hidden">
            <div x-sort class="flex flex-col">
                <!-- dummy item -->
                <div x-sort:item="0" class="hidden">
                    <span x-sort:handle></span>
                </div>

                <template x-for="option in state.options" :key="option.id">
                    <div x-sort:item="option.id" @click="openEditOption(option)"
                        class="p-4 flex space-x-4 border-b border-gray-200 cursor-pointer">
                        <x-tabler-grip-vertical x-sort:handle
                            class="flex-none w-10 h-10 p-2 rounded hover:bg-gray-100 cursor-move" />

                        <div x-show="!option.edit">
                            <div class="font-medium" x-text="option.name"></div>
                            <div class="flex gap-x-3 mt-2">
                                <template x-for="value in option.values">
                                    <x-filament::badge color="gray" x-text="value.label"></x-filament::badge>
                                </template>
                            </div>
                        </div>

                        <div x-show="option.edit" class="flex-1 min-w-0">
                            <div>Option name</div>
                            <x-filament::input.wrapper class="mt-2 w-full"
                                x-bind:class="errors.includes(`options.${option.id}.name`) ? 'fi-invalid' : ''">
                                <x-filament::input type="text" x-model="option.name"
                                    @input="removeError(`options.${option.id}.name`)" />
                            </x-filament::input.wrapper>

                            <div class="mt-3">Option values</div>
                            <div x-sort="sortValues($item, $position, option)"
                                class="flex flex-col gap-y-2 -ml-10 mt-2">
                                <!-- dummy item -->
                                <div x-sort:item="0" class="hidden">
                                    <span x-sort:handle></span>
                                </div>

                                <template x-for="value in option.values" :key="value.id">
                                    <div x-sort:item="value.id" class="flex items-center gap-x-2">
                                        <x-tabler-grip-vertical x-sort:handle
                                            class="flex-none w-8 h-8 p-2 rounded text-gray-500 hover:bg-gray-100 cursor-move" />

                                        <x-filament::input.wrapper class="flex-1 min-w-0"
                                            x-bind:class="errors.includes(`options.${option.id}.values.${value.id}`) ?
                                                'fi-invalid' : ''">
                                            <x-filament::input type="text" x-model="value.label"
                                                @keydown.enter.prevent.stop=""
                                                @input="removeError(`options.${option.id}.values.${value.id}`)" />
                                            <x-slot name="suffix">
                                                <x-heroicon-o-trash
                                                    class="w-7 h-7 rounded p-1 text-red-600 hover:bg-red-100 cursor-pointer"
                                                    @click="removeValue(value.id, option)" />
                                            </x-slot>
                                        </x-filament::input.wrapper>
                                    </div>
                                </template>
                            </div>

                            <x-filament::input.wrapper class="mt-2"
                                x-bind:class="errors.includes('options.${option.id}.value') ? 'fi-invalid' : ''">
                                <x-filament::input type="text" placeholder="Add another value" x-model="option.value"
                                    @keydown.enter.prevent.stop="addValue(option)"
                                    @input="removeError(`options.${option.id}.value`)" />
                            </x-filament::input.wrapper>

                            <div class="mt-3 flex gap-x-2">
                                <x-filament::button size="xs" color="gray"
                                    @click.prevent.stop="closeEditOption(option)">Close</x-filament::button>
                                <x-filament::button size="xs" color="danger" class="ml-auto"
                                    @click.prevent.stop="deleteOption(option.id)">Delete</x-filament::button>
                                <x-filament::button size="xs"
                                    @click.prevent.stop="addOption(option)">Done</x-filament::button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="!dataAddOption.edit" class="flex items-center p-4 cursor-pointer hover:bg-gray-100"
                @click="dataAddOption.edit = !dataAddOption.edit">
                <x-tabler-circle-plus class="mr-3" />
                Add another options
            </div>
            <div x-show="dataAddOption.edit" class="p-4 flex space-x-6">
                <x-tabler-grip-vertical class="flex-none w-10 h-10 p-2 rounded text-gray-400" />
                <div class="flex-1 min-w-0">
                    <div>Option name</div>

                    <x-filament::input.wrapper class="mt-2 w-full"
                        x-bind:class="errors.includes('dataAddOption.name') ? 'fi-invalid' : ''">

                        <x-filament::input type="text" x-model="dataAddOption.name"
                            @input="removeError(`dataAddOption.name`)" />
                    </x-filament::input.wrapper>

                    <div class="mt-3">Option values</div>
                    <div x-sort="sortValues($item, $position)" class="flex flex-col gap-y-2 -ml-10 mt-2">
                        <!-- dummy item -->
                        <div x-sort:item="0" class="hidden">
                            <span x-sort:handle></span>
                        </div>

                        <template x-for="value in dataAddOption.values" :key="value.id">
                            <div x-sort:item="value.id" class="flex items-center gap-x-2">
                                <x-tabler-grip-vertical x-sort:handle
                                    class="flex-none w-8 h-8 p-2 rounded text-gray-500 hover:bg-gray-100 cursor-move" />

                                <x-filament::input.wrapper class="flex-1 min-w-0"
                                    x-bind:class="errors.includes(`dataAddOption.values.${value.id}`) ? 'fi-invalid' : ''">
                                    <x-filament::input type="text" x-model="value.label"
                                        @input="removeError(`dataAddOption.values.${value.id}`)" />

                                    <x-slot name="suffix">
                                        <x-heroicon-o-trash
                                            class="w-7 h-7 rounded p-1 text-red-600 hover:bg-red-100 cursor-pointer"
                                            @click="removeValue(value.id)" />
                                    </x-slot>
                                </x-filament::input.wrapper>
                            </div>
                        </template>
                    </div>

                    <x-filament::input.wrapper class="mt-2"
                        x-bind:class="errors.includes('dataAddOption.value') ? 'fi-invalid' : ''">

                        <x-filament::input type="text" placeholder="Add another value" x-model="dataAddOption.value"
                            @keydown.enter.prevent.stop="addValue()" @input="removeError(`dataAddOption.value`)" />
                    </x-filament::input.wrapper>

                    <div class="mt-3 flex justify-between">
                        <x-filament::button size="xs" color="gray"
                            @click="closeEditOption()">Delete</x-filament::button>
                        <x-filament::button size="xs" @click="addOption()">Done</x-filament::button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Variants Table -->
        <div x-show="state.variants.length > 0" class="flex flex-col mt-4">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border border-gray-200 rounded-lg shadow-xs overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Variant
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Stock
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <template x-for="variant in state.variants" :key="variant.id">
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 flex space-x-3 items-center">
                                            {{-- <div
                                                class="relative w-18 h-18 rounded border border-dashed border-primary-300 text-primary-600 overflow-hidden">
                                                <label>
                                                    <div x-show="!variant.image"
                                                        class="w-full h-full flex items-center justify-center cursor-pointer">
                                                        <x-tabler-cloud-upload />
                                                        <input type="file" class="sr-only" x-model
                                                            @change="await variantUploadFile($event, variant)">
                                                    </div>
                                                    <img x-show="variant.image" :src="variant.image"
                                                        class="w-full h-full object-cover pointer-events-none">
                                                    <x-heroicon-o-trash x-show="variant.image"
                                                        class="absolute right-1 top-1 w-7 h-7 rounded p-1 text-red-600 hover:bg-red-100 cursor-pointer"
                                                        @click.prevent.stop="await variantRemoveFile(variant)" />
                                                </label>
                                            </div> --}}
                                            <span x-text="variant.label"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <x-filament::input.wrapper>
                                                <x-filament::input type="text" {{-- x-mask:dynamic="$money($input)" --}} required
                                                    x-model="variant.price" />
                                            </x-filament::input.wrapper>
                                            {{-- <p class="fi-fo-field-wrp-error-message">Error</p> --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            <x-filament::input.wrapper>
                                                <x-filament::input type="text" x-model="variant.stock" />
                                            </x-filament::input.wrapper>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>

<script type="module">
    import {
        v7 as uuidv7
    } from "https://cdn.jsdelivr.net/npm/uuid/dist/esm-browser/index.js";

    document.addEventListener('alpine:init', () => {
        Alpine.data('product_variants', ($wire, statePath) => ({
            state: $wire.$entangle(statePath),
            dataAddOption: {
                name: '',
                values: [],
                edit: false,
                value: '',
            },
            errors: @js($errors->toArray()),

            init() {
                this.state.options = this.state.options.map(v => ({
                    ...v,
                    edit: false,
                    value: '',
                    original: JSON.parse(JSON.stringify(v))
                }));

                this.state.variants = this.state.variants.map(v => ({
                    ...v,
                    label: v.values.map(v => v.label).join('/')
                }));
            },

            //  ======== OPTIONS ========

            addValue(option) {
                const currentOption = option ?? this.dataAddOption
                const errorString = option ? `options.${option.id}` : 'dataAddOption'

                if (!currentOption.value) {
                    return this.addError(`${errorString}.value`)
                }

                currentOption.values.push({
                    id: uuidv7(),
                    label: currentOption.value,
                    position: currentOption.values.length + 1
                })
                currentOption.value = ''
            },

            removeValue(id, option) {
                const currentOption = option ?? this.dataAddOption
                const errorString = option ? `options.${option.id}` : 'dataAddOption'

                currentOption.values = currentOption.values.filter(v => v.id != id)
                this.removeError(`${errorString}.values.${id}`)
            },

            sortValues(itemId, newPos, option) {
                const currentOption = option ?? this.dataAddOption

                const moved = currentOption.values.find(v => v.id === itemId)
                if (!moved) return

                const oldPos = moved.position
                moved.position = newPos

                currentOption.values.forEach(v => {
                    if (v.id === itemId) return

                    if (oldPos > newPos) {
                        if (v.position >= newPos && v.position < oldPos) {
                            v.position += 1
                        }
                    } else if (oldPos < newPos) {
                        if (v.position > oldPos && v.position <= newPos) {
                            v.position -= 1
                        }
                    }
                })
            },

            addOption(option) {
                const currentOption = option ?? this.dataAddOption
                const errorString = option ? `options.${option.id}` : 'dataAddOption'

                if (!currentOption.name) {
                    return this.addError(`${errorString}.name`)
                }

                if (currentOption.values.length == 0) {
                    return this.addError(`${errorString}.value`)
                }

                for (let value of currentOption.values) {
                    if (!value.label) {
                        return this.addError(`${errorString}.values.${value.id}`)
                    }
                }

                if (!option) {
                    this.state.options.push({
                        id: uuidv7(),
                        name: currentOption.name,
                        values: currentOption.values,
                        edit: false,
                        value: ''
                    });
                }

                this.closeEditOption(option)
                this.generateVariants()
            },

            openEditOption(option) {
                option.edit = true;
                option.original = JSON.parse(JSON.stringify(option));
            },

            closeEditOption(option) {
                if (option) {
                    option.name = option.original.name;
                    option.values = JSON.parse(JSON.stringify(option.original.values));
                    option.value = ''
                    option.edit = false
                } else {
                    this.dataAddOption = {
                        name: '',
                        values: [],
                        value: '',
                        edit: false
                    }
                }
            },

            deleteOption(id) {
                this.state.options = this.state.options.filter(o => o.id != id)

                this.generateVariants()
            },

            //  ======== END OPTIONS ========


            //  ======== VARIANTS ========

            generateVariants() {
                if (!this.state.options.length) return;

                let arrays = this.state.options.map(o => o.values);
                let combos = this.cartesian(arrays);

                let oldIndex = {};
                for (let v of this.state.variants) {
                    let key = v.values.map(c => c.id).join('-');
                    oldIndex[key] = v;
                }

                this.state.variants = combos.map(combo => {
                    let key = combo.map(c => c.id).join('-');
                    let old = oldIndex[key];

                    return old ? {
                        ...old,
                        values: combo,
                        label: combo.map(v => v.label).join('/'),
                    } : {
                        id: uuidv7(),
                        image: null,
                        values: combo,
                        label: combo.map(v => v.label).join('/'),
                        price: 0,
                        stock: 0
                    };
                });
            },

            cartesian(arrays) {
                return arrays.reduce(
                    (acc, group) =>
                    acc.flatMap(obj =>
                        group.map(item => [
                            ...obj,
                            {
                                option_id: item.id,
                                label: item.label
                            }
                        ])
                    ),
                    [
                        []
                    ]
                );
            },

            async variantUploadFile(event, variant) {
                const file = event.target.files[0]
                if (!file) return;

                variant.image_file = file
                variant.image = URL.createObjectURL(file);
            },

            async variantRemoveFile(variant) {
                if (variant.image) {
                    URL.revokeObjectURL(variant.image);
                }

                variant.image_file = null
                variant.image = null;
            },

            //  ======== END VARIANTS ========

            addError(name) {
                if (!this.errors.includes(name)) {
                    this.errors.push(name)
                }
            },

            removeError(name) {
                this.errors = this.errors.filter(v => v != name)
            }
        }))
    })
</script>
