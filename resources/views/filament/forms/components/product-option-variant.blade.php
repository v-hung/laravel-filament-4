<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="product_variants($wire, @js($getStatePath()))" {{ $getExtraAttributeBag() }} class="space-y-4">
        <!-- Options -->
        <div>
            {{-- <x-filament::button icon="heroicon-s-plus" outlined size="xs" color="gray"
                class="absolute -top-8 right-0">
                Add Option
            </x-filament::button> --}}

            <div class="border border-gray-300 rounded-lg flex flex-col divide-solid divide-y divide-gray-200 mt-2 mb-4">
                <div class="p-4">sdf</div>
                <div class="p-4">sdf</div>
                <div class="p-4">sdf</div>
            </div>

            <template x-for="(option, i) in state.options" :key="i">
                <div class="mt-2 p-2 border rounded">
                    <input type="text" class="border px-2 py-1" x-model="option.name"
                        placeholder="Option name (e.g. Size)" />

                    <button type="button" class="ml-2 text-sm text-blue-500" @click="addValue(option)">+ Add
                        Value</button>

                    <div class="mt-2 flex flex-wrap gap-2">
                        <template x-for="(value, j) in option.values" :key="j">
                            <input type="text" class="border px-2 py-1" x-model="option.values[j]"
                                placeholder="Value" />
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Variants Table -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border border-gray-200 rounded-lg shadow-xs overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Age
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Address
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">John Brown
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">45</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">New York No. 1 Lake
                                        Park</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Jim Green
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">27</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">London No. 1 Lake Park
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Joe Black
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">31</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Sidney No. 1 Lake Park
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <button type="button"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('product_variants', ($wire, statePath) => ({
            state: $wire.$entangle(statePath),

            addOption() {
                this.state.options.push({
                    name: '',
                    values: []
                });
            },

            addValue(option) {
                option.values.push('');
            },

            generateVariants() {
                if (!this.state.options.length) return;

                let arrays = this.state.options.map(o => o.values.filter(v => v !== ''));
                let combos = this.cartesian(arrays);

                this.state.variants = combos.map(c => ({
                    name: c.join(' / '),
                    price: null,
                    stock: null,
                    sku: null,
                }));
            },

            cartesian(arrays) {
                return arrays.reduce((a, b) =>
                    a.flatMap(d => b.map(e => [...(Array.isArray(d) ? d : [d]), e]))
                );
            }
        }))
    })
</script>
