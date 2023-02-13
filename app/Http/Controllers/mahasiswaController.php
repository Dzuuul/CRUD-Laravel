<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class mahasiswaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // Search
    $katakunci = $request->katakunci;
    $row = 4;
    if (strlen($katakunci)) {
      $data = mahasiswa::where('nim', 'like', "%$katakunci%")
        ->orWhere('nama', 'like', "%$katakunci%")
        ->orWhere('jurusan', 'like', "%$katakunci%")
        ->paginate($row);
    } else {
      // Pagination disini
      $data = mahasiswa::orderBy('nim', 'desc')->paginate(5);
    }

    return view('mahasiswa.index')->with('data', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('mahasiswa.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    Session::flash('nim', $request->nim);
    Session::flash('nama', $request->nama);
    Session::flash('jurusan', $request->jurusan);

    $request->validate([
      'nim' => 'required|numeric|unique:mahasiswa,nim',
      'nama' => 'required',
      'jurusan' => 'required',
    ], [
        'nim.required' => 'NIM wajib diisi!',
        'nim.numeric' => 'NIM hanya bisa menggunakan angka!',
        'nim.unique' => 'NIM sudah ada!',
        'nama.required' => 'Nama wajib diisi!',
        'jurusan.required' => 'Jurusan wajib diisi!',
      ]);
    $data = [
      'nim' => $request->nim,
      'nama' => $request->nama,
      'jurusan' => $request->jurusan,
    ];
    mahasiswa::create($data);
    return redirect()->to('mahasiswa')->with('success', 'Berhasil Menambahkan Data!');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    // edit button functionality
    $data = mahasiswa::where('nim', $id)->first();
    return view('mahasiswa.edit')->with('data', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required',
      'jurusan' => 'required',
    ], [
        'nama.required' => 'Nama wajib diisi!',
        'jurusan.required' => 'Jurusan wajib diisi!',
      ]);
    $data = [
      'nama' => $request->nama,
      'jurusan' => $request->jurusan,
    ];
    mahasiswa::where('nim', $id)->update($data);
    return redirect()->to('mahasiswa')->with('success', 'Berhasil Update Data!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    mahasiswa::where('nim', $id)->delete();
    return redirect()->to('mahasiswa')->with('success', 'Berhasil Menghapus Data');
  }
}
