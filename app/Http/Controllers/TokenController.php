<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokens = Auth::user()->tokens()->latest()->get();
        return view('tokens.index', compact('tokens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tokens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
            'expires_at' => ['nullable', 'date', 'after:now'],
        ]);

        $token = Token::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'token' => Token::generateToken(),
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('tokens.show', $token)
            ->with('success', 'Token created successfully!')
            ->with('new_token', $token->token);
    }

    /**
     * Display the specified resource.
     */
    public function show(Token $token)
    {
        $this->authorize('view', $token);
        return view('tokens.show', compact('token'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Token $token)
    {
        $this->authorize('update', $token);
        return view('tokens.edit', compact('token'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Token $token)
    {
        $this->authorize('update', $token);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
            'expires_at' => ['nullable', 'date', 'after:now'],
            'is_active' => ['boolean'],
        ]);

        $token->update([
            'name' => $request->name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
            'expires_at' => $request->expires_at,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('tokens.show', $token)
            ->with('success', 'Token updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Token $token)
    {
        $this->authorize('delete', $token);
        
        $token->delete();

        return redirect()->route('tokens.index')
            ->with('success', 'Token deleted successfully!');
    }

    /**
     * Regenerate the token.
     */
    public function regenerate(Token $token)
    {
        $this->authorize('update', $token);

        $newToken = Token::generateToken();
        $token->update(['token' => $newToken]);

        return redirect()->route('tokens.show', $token)
            ->with('success', 'Token regenerated successfully!')
            ->with('new_token', $newToken);
    }

    /**
     * Toggle token active status.
     */
    public function toggle(Token $token)
    {
        $this->authorize('update', $token);

        $token->update(['is_active' => !$token->is_active]);

        $status = $token->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Token {$status} successfully!");
    }
}
