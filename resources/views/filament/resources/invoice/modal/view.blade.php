<div class="p-6" style="--primary-color: #0f2147; --primary-light: #dbeafe; --secondary-color: #475569; --accent-color: #f8fafc;">
    <div class="space-y-6">
        {{-- Invoice Header --}}
        <table class="w-full">
            <tr>
                <td class="w-1/2 align-top">
                    <div class="font-semibold text-[#0f2147] mb-2">Bill To:</div>
                    <p>{{ $invoice->customer->nama }}</p>
                    <p>Email: {{ $invoice->customer->email }}</p>
                    <p>Phone: {{ $invoice->customer->phone }}</p>
                </td>
                <td class="w-1/2 text-right align-top">
                    <div class="flex justify-end items-center">
                        <div class="text-lg font-bold text-[#0f2147]">
                            INVOICE #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                        <span @class([
                            'ml-2 px-2 py-1 rounded-md text-xs font-semibold',
                            'bg-yellow-100 text-yellow-800' => $invoice->status === 'pending',
                            'bg-green-100 text-green-800' => $invoice->status === 'paid',
                            'bg-red-100 text-red-800' => $invoice->status === 'cancelled',
                        ])>
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                    <p class="mt-2">Invoice Date: {{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</p>
                    <p>Due Date: {{ date('d/m/Y', strtotime($invoice->due_date)) }}</p>
                </td>
            </tr>
        </table>

        {{-- Items Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0f2147] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left w-[30%]">ITEM</th>
                        <th class="px-4 py-2 text-left w-[25%]">DESCRIPTION</th>
                        <th class="px-4 py-2 text-center w-[10%]">QTY</th>
                        <th class="px-4 py-2 text-right w-[17%]">PRICE</th>
                        <th class="px-4 py-2 text-right w-[18%]">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->item as $item)
                        <tr class="border-t even:bg-[#f8fafc]">
                            <td class="px-4 py-2 font-semibold">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->description }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-right">
                                @if($item->is_dollar)
                                    ${{ number_format($item->price_dollar, 2) }}
                                @else
                                    Rp {{ number_format($item->price_rupiah, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right">
                                @if($item->is_dollar)
                                    ${{ number_format($item->amount_dollar, 2) }}
                                @else
                                    Rp {{ number_format($item->amount_rupiah, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="flex justify-end">
            <div class="w-1/3 bg-[#f8fafc] p-4 rounded-lg space-y-2">
                <div class="flex justify-between text-[#475569]">
                    <span>Subtotal IDR:</span>
                    <span>Rp {{ number_format($invoice->item->where('is_dollar', false)->sum('amount_rupiah'), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-[#475569]">
                    <span>Subtotal USD:</span>
                    <span>${{ number_format($invoice->item->where('is_dollar', true)->sum('amount_dollar'), 2) }}</span>
                </div>
                <div class="flex justify-between font-bold border-t border-gray-200 pt-2 text-[#0f2147]">
                    <span>Total Amount:</span>
                    <span>Rp {{ number_format(
                        $invoice->item->where('is_dollar', false)->sum('amount_rupiah') + 
                        ($invoice->item->where('is_dollar', true)->sum('amount_dollar') * $invoice->current_dollar), 
                        0, ',', '.'
                    ) }}</span>
                </div>
                <div class="text-xs text-[#666666] pt-1">
                    Exchange Rate: 1 USD = Rp {{ number_format($invoice->current_dollar, 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="mt-6 text-center bg-[#f8fafc] p-4 rounded-lg">
            <p class="font-semibold">INFORMASI PEMBAYARAN:</p>
            <p>BRI | 398329283298 | a.n Wahyu</p>
        </div>

        {{-- Footer --}}
        <div class="text-center text-sm text-[#475569] mt-6 pt-4 border-t border-[#dbeafe]">
            <p class="font-semibold text-[#0f2147]">Thank you for your business!</p>
            <p class="text-xs">This is a computer-generated document. No signature is required.</p>
            <p class="text-xs">Generated on {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</div>
