@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card p-4 border border-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Customer Profiles</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customerDetails as $detail)
                                <tr>
                                    <td>
                                        @if ($detail->picture)
                                            <img src="{{ asset('storage/' . $detail->picture) }}" alt="{{ $detail->fname }}"
                                                width="60" class="rounded-circle">
                                        @else
                                            <span class="text-muted">No picture</span>
                                        @endif
                                    </td>
                                    <td>{{ $detail->lname }}, {{ $detail->fname }} {{ $detail->mname }}</td>
                                    <td>{{ $detail->contact_number }}</td>
                                    <td>{{ $detail->email }}</td>
                                    <td>{{ $detail->address }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-info show-btn" data-bs-toggle="modal"
                                            data-bs-target="#showCustomerModal"
                                            data-picture="{{ $detail->picture ? asset('storage/' . $detail->picture) : '' }}"
                                            data-lname="{{ $detail->lname }}" data-fname="{{ $detail->fname }}"
                                            data-mname="{{ $detail->mname ?? '' }}"
                                            data-contact="{{ $detail->contact_number }}" data-email="{{ $detail->email }}"
                                            data-address="{{ $detail->address }}">
                                            <i class="ti ti-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No profile records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $customerDetails->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showCustomerModal" tabindex="-1" aria-labelledby="showCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modal-picture" src="" alt="Customer Picture" class="rounded-circle mb-3"
                        style="width:120px; height:120px; object-fit:cover;">
                    <h5 id="modal-fullname" class="mb-2"></h5>
                    <p><strong>Contact:</strong> <span id="modal-contact"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email"></span></p>
                    <p><strong>Address:</strong> <span id="modal-address"></span></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('showCustomerModal');

                modal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget;

                    const picture = button.getAttribute('data-picture') || '';
                    const lname = button.getAttribute('data-lname') || '';
                    const fname = button.getAttribute('data-fname') || '';
                    const mname = button.getAttribute('data-mname') || '';
                    const contact = button.getAttribute('data-contact') || '';
                    const email = button.getAttribute('data-email') || '';
                    const address = button.getAttribute('data-address') || '';

                    const fullname = `${fname} ${mname ? mname + ' ' : ''}${lname}`;

                    document.getElementById('modal-picture').src = picture ||
                        '{{ asset('images/default-avatar.png') }}';
                    document.getElementById('modal-fullname').textContent = fullname;
                    document.getElementById('modal-contact').textContent = contact;
                    document.getElementById('modal-email').textContent = email;
                    document.getElementById('modal-address').textContent = address;
                });
            });
        </script>
    @endpush
@endsection
