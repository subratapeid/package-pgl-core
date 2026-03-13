<?php

namespace Pgl\Core\Admin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Pgl\Core\Admin\Actions\Media\DeleteMediaAction;
use Pgl\Core\Admin\Actions\Media\UploadMediaAction;
use Pgl\Core\Admin\AdminViewFactory;
use Pgl\Core\Admin\Http\Requests\Media\UploadMediaRequest;
use Pgl\Core\Admin\Services\MediaLibraryService;

class MediaController extends AdminController
{
    public function __construct(
        AdminViewFactory $adminViewFactory,
        private readonly MediaLibraryService $mediaLibraryService,
        private readonly UploadMediaAction $uploadMediaAction,
        private readonly DeleteMediaAction $deleteMediaAction,
    ) {
        parent::__construct($adminViewFactory);
    }

    public function index(): View
    {
        return $this->adminView('media.index', [
            'pageTitle' => 'Media Library',
            'mediaItems' => $this->mediaLibraryService->all(),
        ]);
    }

    public function store(UploadMediaRequest $request): RedirectResponse
    {
        ($this->uploadMediaAction)(
            $request->file('file'),
            $request->validated('name'),
        );

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Media uploaded.');
    }

    public function destroy(int $assetId): RedirectResponse
    {
        ($this->deleteMediaAction)($assetId);

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Media deleted.');
    }
}