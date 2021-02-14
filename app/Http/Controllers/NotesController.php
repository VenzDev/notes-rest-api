<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends ApiController
{
    public function getNotes()
    {
        try {
            $notes = Note::all()->where('deleted', false);

            foreach ($notes as $note) {
                $version = Version::find($note->latest_version_id);
                $note->setAttribute('latest_version', $version);
            }
            return $this->successResponse($notes);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function getNote($id)
    {
        try {
            $note = Note::find($id);
            $version = Version::find($note->latest_version_id);
            $note->setAttribute('latest_version', $version);
            return $this->successResponse($note);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function getNoteHistory($id)
    {
        try {
            $versions = Version::where('note_id', $id)->orderBy('version_id', 'DESC')->get();
            return $this->successResponse($versions);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function createNote(Request $request)
    {
        $validator = $this->validateCreateRequest();
        if ($validator->fails()) {
            return $this->errorResponse($validator->getMessageBag(), 422);
        }

        try {
            $note = new Note();
            $note->save();

            $version = new Version();
            $version->version_id = 1;
            $version->title = $request->title;
            $version->content = $request->content;
            $version->note_id = $note->id;
            $version->save();

            $note->update(['latest_version_id' => $version->id]);

            return $this->successResponse($version);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function updateNote(Request $request)
    {
        $validator = $this->validateUpdateRequest();
        if ($validator->fails()) {
            return $this->errorResponse($validator->getMessageBag(), 422);
        }

        try {
            $prev_version = Version::where('note_id', $request->id)->orderBy('version_id', 'DESC')->first();

            $new_version = new Version();
            $new_version->version_id = $prev_version->version_id + 1;
            $new_version->title = $request->title;
            $new_version->content = $request->content;
            $new_version->note_id = $request->id;
            $new_version->save();

            $note = Note::find($request->id);
            $note->update(['latest_version_id' => $new_version->id]);

            return $this->successResponse($new_version);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function deleteNote($id)
    {
        try {
            $note = Note::find($id);
            $note->deleted = true;
            $note->save();
            return $this->successResponse($note);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong!', 422);
        }
    }

    public function validateUpdateRequest()
    {
        return Validator::make(request()->all(), [
            'id' => 'required',
            'title' => 'required|max:190',
            'content' => 'required|max:190'
        ]);
    }

    public function validateCreateRequest()
    {
        return Validator::make(request()->all(), [
            'title' => 'required|max:190',
            'content' => 'required|max:190'
        ]);
    }
}
